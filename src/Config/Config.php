<?php

namespace srag\AVL\Plugins\MailLogger\Config;

use ilMailLoggerPlugin;
use MailLoggerRemoveDataConfirm;
use srag\ActiveRecordConfig\ActiveRecordConfig;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Config
 *
 * @package srag\AVL\Plugins\MailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Config extends ActiveRecordConfig {

	use MailLoggerTrait;
	const TABLE_NAME = "maillog_config";
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	const KEY_LOG_EMAIL_OF_USERS = "log_email_of_users";
	const KEY_LOG_SYSTEM_EMAILS = "log_system_emails";
	const DEFAULT_LOG_EMAIL_OF_USERS = [];
	const DEFAULT_LOG_SYSTEM_EMAILS = false;


	/**
	 * @return array
	 */
	public static function getLogEmailOfUsers(): array {
		return self::getJsonValue(self::KEY_LOG_EMAIL_OF_USERS, true, self::DEFAULT_LOG_EMAIL_OF_USERS);
	}


	/**
	 * @param array $log_email_of_users
	 */
	public static function setLogEmailOfUsers(array $log_email_of_users)/*: void*/ {
		self::setJsonValue(self::KEY_LOG_EMAIL_OF_USERS, $log_email_of_users);
	}


	/**
	 * @return bool
	 */
	public static function getLogSystemEmails(): bool {
		return self::getBooleanValue(self::KEY_LOG_SYSTEM_EMAILS, self::DEFAULT_LOG_SYSTEM_EMAILS);
	}


	/**
	 * @param bool $log_system_emails
	 */
	public static function setLogSystemEmails(bool $log_system_emails)/*: void*/ {
		self::setBooleanValue(self::KEY_LOG_SYSTEM_EMAILS, $log_system_emails);
	}


	/**
	 * @return bool|null
	 */
	public static function getUninstallRemovesData()/*: ?bool*/ {
		return self::getXValue(MailLoggerRemoveDataConfirm::KEY_UNINSTALL_REMOVES_DATA, MailLoggerRemoveDataConfirm::DEFAULT_UNINSTALL_REMOVES_DATA);
	}


	/**
	 * @param bool $uninstall_removes_data
	 */
	public static function setUninstallRemovesData(bool $uninstall_removes_data)/*: void*/ {
		self::setBooleanValue(MailLoggerRemoveDataConfirm::KEY_UNINSTALL_REMOVES_DATA, $uninstall_removes_data);
	}


	/**
	 *
	 */
	public static function removeUninstallRemovesData()/*: void*/ {
		self::removeName(MailLoggerRemoveDataConfirm::KEY_UNINSTALL_REMOVES_DATA);
	}
}
