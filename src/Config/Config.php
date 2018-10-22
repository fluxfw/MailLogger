<?php

namespace srag\AVL\Plugins\AVLMailLogger\Config;

use AVLMailLoggerRemoveDataConfirm;
use ilAVLMailLoggerPlugin;
use srag\ActiveRecordConfig\ActiveRecordConfig;
use srag\AVL\Plugins\AVLMailLogger\Utils\AVLMailLoggerTrait;

/**
 * Class Config
 *
 * @package srag\AVL\Plugins\AVLMailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Config extends ActiveRecordConfig {

	use AVLMailLoggerTrait;
	const TABLE_NAME = "avlmalo_config";
	const PLUGIN_CLASS_NAME = ilAVLMailLoggerPlugin::class;


	/**
	 * @return bool|null
	 */
	public static function getUninstallRemovesData()/*: ?bool*/ {
		return self::getXValue(AVLMailLoggerRemoveDataConfirm::KEY_UNINSTALL_REMOVES_DATA, AVLMailLoggerRemoveDataConfirm::DEFAULT_UNINSTALL_REMOVES_DATA);
	}


	/**
	 * @param bool $uninstall_removes_data
	 */
	public static function setUninstallRemovesData(bool $uninstall_removes_data)/*: void*/ {
		self::setBooleanValue(AVLMailLoggerRemoveDataConfirm::KEY_UNINSTALL_REMOVES_DATA, $uninstall_removes_data);
	}


	/**
	 *
	 */
	public static function removeUninstallRemovesData()/*: void*/ {
		self::removeName(AVLMailLoggerRemoveDataConfirm::KEY_UNINSTALL_REMOVES_DATA);
	}
}
