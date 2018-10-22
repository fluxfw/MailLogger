<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use srag\AVL\Plugins\MailLogger\Config\Config;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\RemovePluginDataConfirm\AbstractRemovePluginDataConfirm;

/**
 * Class MailLoggerRemoveDataConfirm
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy MailLoggerRemoveDataConfirm: ilUIPluginRouterGUI
 */
class MailLoggerRemoveDataConfirm extends AbstractRemovePluginDataConfirm {

	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


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
