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
		// TODO: Implement handleEvent
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
