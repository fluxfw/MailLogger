<?php

namespace srag\AVL\Plugins\MailLogger\Log;

use ilMailLoggerPlugin;
use ilMimeMail;
use ilObjUser;
use srag\AVL\Plugins\MailLogger\Config\Config;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\DIC\DICTrait;
use stdClass;

/**
 * Class LogHandler
 *
 * @package srag\AVL\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class LogHandler {

	use DICTrait;
	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	/**
	 * @var self
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
	 * LogHandler constructor
	 */
	protected function __construct() {
	}


	/**
	 * @param array $mail
	 */
	public function handleSendInternalEmail(array $mail)/*: void*/ {
		$from_user = new ilObjUser($mail["from_user_id"]);
		$to_user = new ilObjUser($mail["to_user_id"]);

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
	public function handleSendExternalEmail(ilMimeMail $mail)/*: void*/ {
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

			$log->setIsSystem($mail->is_system);

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
}
