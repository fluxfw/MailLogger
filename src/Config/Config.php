<?php

namespace srag\AVL\Plugins\MailLogger\Config;

use ilMailLoggerPlugin;
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
	/**
	 * @var array
	 */
	protected static $fields = [
		self::KEY_LOG_EMAIL_OF_USERS => [ self::TYPE_JSON, [] ],
		self::KEY_LOG_SYSTEM_EMAILS => self::TYPE_BOOLEAN
	];
}
