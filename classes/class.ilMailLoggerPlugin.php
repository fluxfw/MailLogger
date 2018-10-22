<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\AVL\Plugins\MailLogger\Access\Access;
use srag\AVL\Plugins\MailLogger\Config\Config;
use srag\AVL\Plugins\MailLogger\Log\Log;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\Plugins\CtrlMainMenu\Entry\ctrlmmEntry;
use srag\Plugins\CtrlMainMenu\EntryTypes\Ctrl\ctrlmmEntryCtrl;
use srag\Plugins\CtrlMainMenu\Menu\ctrlmmMenu;
use srag\RemovePluginDataConfirm\PluginUninstallTrait;

/**
 * Class ilMailLoggerPlugin
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilMailLoggerPlugin extends ilEventHookPlugin {

	use PluginUninstallTrait;
	use MailLoggerTrait;
	const PLUGIN_ID = "maillog";
	const PLUGIN_NAME = "MailLogger";
	const PLUGIN_CLASS_NAME = self::class;
	const REMOVE_PLUGIN_DATA_CONFIRM_CLASS_NAME = MailLoggerRemoveDataConfirm::class;
	const COMPONENT_MAIL = "Services/Mail";
	const EVENT_SEND_EXTERNAL_EMAIL = "sendExternalEmail";
	const EVENT_SEND_INTERNAL_EMAIL = "sendInternalEmail";
	/**
	 * @var self|null
	 */
	protected static $instance = NULL;


	/**
	 * @return self
	 */
	public static function getInstance(): self {
		if (self::$instance === NULL) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * ilMailLoggerPlugin constructor
	 */
	public function __construct() {
		parent::__construct();
	}


	/**
	 * @return string
	 */
	public function getPluginName(): string {
		return self::PLUGIN_NAME;
	}


	/**
	 *
	 */
	protected function afterActivation()/*: void*/ {
		$this->addCtrlMainMenu();
	}


	/**
	 *
	 */
	protected function afterDeactivation()/*: void*/ {
		$this->removeCtrlMainMenu();
	}


	/**
	 * @param string $a_component
	 * @param string $a_event
	 * @param array  $a_parameter
	 */
	public function handleEvent(/*string*/
		$a_component, /*string*/
		$a_event,/*array*/
		$a_parameter)/*: void*/ {
		if ($a_component === self::COMPONENT_MAIL) {
			switch ($a_event) {
				case self::EVENT_SEND_INTERNAL_EMAIL:
					$mail = $a_parameter;
					$this->handleSendInternalEmail($mail);
					break;

				case self::EVENT_SEND_EXTERNAL_EMAIL:
					$mail = $a_parameter["mail"];
					$this->handleSendExternalEmail($mail);
					break;

				default:
					break;
			}
			exit;
		}
	}


	/**
	 * @param array $mail
	 */
	protected function handleSendInternalEmail(array $mail) {
		$from_user = new ilObjUser($mail["from_user_id"]);

		$to_user_id = current(ilObjUser::_getUserIdsByEmail($mail["to_email"]));
		if (!empty($to_user_id)) {
			$to_user_id = ilObjUser::_lookupId($to_user_id);
			if (!empty($to_user_id)) {
				$to_user = new ilObjUser($to_user_id);
			} else {
				$to_user = new ilObjUser();
				$to_user->setEmail($mail["to_email"]);
			}
		} else {
			$to_user_id = ilObjUser::_lookupId($mail["to_email"]);
			if (!empty($to_user_id)) {
				$to_user = new ilObjUser($to_user_id);
			} else {
				$to_user = new ilObjUser();
				$to_user->fullname = $mail["to_email"];
				$to_user->setEmail("");
			}
		}

		$this->log((object)[
			"subject" => $mail["subject"],
			"body" => $mail["body"],
			"is_system" => $mail["is_system"],
			"from_name" => $from_user->getFullname(),
			"from_email" => $from_user->getEmail(),
			"from_user_id" => intval($from_user->getId()),
			"to_name" => $to_user->getFullname(),
			"to_email" => $to_user->getEmail(),
			"to_user_id" => intval($to_user->getId()),
			"context_ref_id" => (!empty($mail["context_ref_id"]) ? $mail["context_ref_id"] : - 1)
		]);
	}


	/**
	 * @param ilMimeMail $mail
	 */
	protected function handleSendExternalEmail(ilMimeMail $mail) {
		$from_user_id = ilObjUser::_lookupId(current(ilObjUser::_getUserIdsByEmail($mail->getFrom()->getFromAddress())));

		foreach ($mail->getTo() as $to) {
			$to_user_id = ilObjUser::_lookupId(current(ilObjUser::_getUserIdsByEmail($to[0])));

			$this->log((object)[
				"subject" => $mail->getSubject(),
				"body" => $mail->getFinalBody(),
				"is_system" => ($mail->getFrom() instanceof ilMailMimeSenderSystem),
				"from_name" => $mail->getFrom()->getFromName(),
				"from_email" => $mail->getFrom()->getFromAddress(),
				"from_user_id" => (!empty($from_user_id) ? intval($from_user_id) : - 1),
				"to_name" => $to[1],
				"to_email" => $to[0],
				"to_user_id" => (!empty($to_user_id) ? intval($to_user_id) : - 1),
				"context_ref_id" => - 1
			]);
		}
	}


	/**
	 * @param stdClass $mail
	 */
	protected function log(stdClass $mail)/*: void*/ {
		if ($this->shouldLog($mail)) {
			$log = new Log();

			$log->setSubject($mail->subject);

			$log->setBody($mail->body);

			$log->setFromName($mail->from_name);
			$log->setFromEmail($mail->from_email);
			$log->setFromUserId($mail->from_user_id);

			$log->setToName($mail->to_name);
			$log->setToEmail($mail->to_email);
			$log->setToUserId($mail->to_user_id);

			$log->setContextRefId($mail->context_ref_id);

			$time = time();
			$log->setTimestamp($time);

			$log->store();
		}
	}


	/**
	 * @param stdClass $mail
	 *
	 * @return bool
	 */
	protected function shouldLog(stdClass $mail): bool {
		if ($mail->is_system) {
			return Config::getLogSystemEmails();
		} else {
			$log_email_of_users = Config::getLogEmailOfUsers();

			return in_array($mail->from_user_id, $log_email_of_users);
		}
	}


	/**
	 * @inheritdoc
	 */
	protected function deleteData()/*: void*/ {
		self::dic()->database()->dropTable(Config::TABLE_NAME, false);
		self::dic()->database()->dropTable(Log::TABLE_NAME, false);

		$this->removeCtrlMainMenu();
	}


	/**
	 *
	 */
	protected function addCtrlMainMenu()/*: void*/ {
		try {
			include_once __DIR__ . "/../../../../UIComponent/UserInterfaceHook/CtrlMainMenu/vendor/autoload.php";

			if (class_exists(ctrlmmEntry::class)) {
				if (count(ctrlmmEntry::getEntriesByCmdClass(MailLoggerLogGUI::class)) === 0) {
					$entry = new ctrlmmEntryCtrl();
					$entry->setTitle(self::PLUGIN_NAME);
					$entry->setTranslations([
						"en" => self::PLUGIN_NAME,
						"de" => self::PLUGIN_NAME
					]);
					$entry->setGuiClass(implode(",", [ ilUIPluginRouterGUI::class, MailLoggerLogGUI::class ]));
					$entry->setCmd(MailLoggerLogGUI::CMD_LOG);
					$entry->setPermissionType(ctrlmmMenu::PERM_SCRIPT);
					$entry->setPermission(json_encode([
						__DIR__ . "/../vendor/autoload.php",
						Access::class,
						"hasLogAccess"
					]));
					$entry->store();
				}
			}
		} catch (Throwable $ex) {
		}
	}


	/**
	 *
	 */
	protected function removeCtrlMainMenu()/*: void*/ {
		try {
			include_once __DIR__ . "/../../../../UIComponent/UserInterfaceHook/CtrlMainMenu/vendor/autoload.php";

			if (class_exists(ctrlmmEntry::class)) {
				foreach (ctrlmmEntry::getEntriesByCmdClass(MailLoggerLogGUI::class) as $entry) {
					/**
					 * @var ctrlmmEntry $entry
					 */
					$entry->delete();
				}
			}
		} catch (Throwable $ex) {
		}
	}
}
