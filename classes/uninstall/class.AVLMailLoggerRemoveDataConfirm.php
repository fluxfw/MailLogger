<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use srag\AVL\Plugins\AVLMailLogger\Config\Config;
use srag\AVL\Plugins\AVLMailLogger\Utils\AVLMailLoggerTrait;
use srag\RemovePluginDataConfirm\AbstractRemovePluginDataConfirm;

/**
 * Class AVLMailLoggerRemoveDataConfirm
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy AVLMailLoggerRemoveDataConfirm: ilUIPluginRouterGUI
 */
class AVLMailLoggerRemoveDataConfirm extends AbstractRemovePluginDataConfirm {

	use AVLMailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilAVLMailLoggerPlugin::class;


	/**
	 * @inheritdoc
	 */
	public function getUninstallRemovesData()/*: ?bool*/ {
		return Config::getUninstallRemovesData();
	}


	/**
	 * @inheritdoc
	 */
	public function setUninstallRemovesData(/*bool*/
		$uninstall_removes_data)/*: void*/ {
		Config::setUninstallRemovesData($uninstall_removes_data);
	}


	/**
	 * @inheritdoc
	 */
	public function removeUninstallRemovesData()/*: void*/ {
		Config::removeUninstallRemovesData();
	}
}
