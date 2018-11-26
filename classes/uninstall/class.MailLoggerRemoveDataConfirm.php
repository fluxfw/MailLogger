<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use srag\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\RemovePluginDataConfirm\MailLogger\AbstractRemovePluginDataConfirm;

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
}
