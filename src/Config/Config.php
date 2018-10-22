<?php

namespace srag\AVL\Plugins\MailLogger\Config;

use MailLoggerRemoveDataConfirm;
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
