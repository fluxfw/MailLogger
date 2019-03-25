<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\ActiveRecordConfig\MailLogger\ActiveRecordConfigGUI;
use srag\Plugins\MailLogger\Config\ConfigFormGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class ilMailLoggerConfigGUI
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilMailLoggerConfigGUI extends ActiveRecordConfigGUI {

	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	/**
	 * @var array
	 */
	protected static $tabs = [ self::TAB_CONFIGURATION => ConfigFormGUI::class ];
}
