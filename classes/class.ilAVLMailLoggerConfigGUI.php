<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\ActiveRecordConfig\ActiveRecordConfigGUI;
use srag\AVL\Plugins\AVLMailLogger\Config\ConfigFormGUI;
use srag\AVL\Plugins\AVLMailLogger\Utils\AVLMailLoggerTrait;

/**
 * Class ilAVLMailLoggerConfigGUI
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilAVLMailLoggerConfigGUI extends ActiveRecordConfigGUI {

	use AVLMailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilAVLMailLoggerPlugin::class;
	/**
	 * @var array
	 */
	protected static $tabs = [ self::TAB_CONFIGURATION => ConfigFormGUI::class ];
}
