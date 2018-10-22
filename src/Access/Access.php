<?php

namespace srag\AVL\Plugins\AVLMailLogger\Access;

use AVLOrgUnitOverviewGUI;
use ilAVLMailLoggerPlugin;
use ilDate;
use ilLPStatus;
use ilMStListCourse;
use ilObjectFactory;
use ilObjOrgUnit;
use ilObjUser;
use ilOrgUnitPathStorage;
use ilOrgUnitPosition;
use ilOrgUnitUserAssignment;
use ilRepUtil;
use ilUserSearchOptions;
use srag\ActiveRecordConfig\ActiveRecordConfig;
use srag\AVL\Plugins\AVLMailLogger\Assistants\Assistant;
use srag\AVL\Plugins\AVLMailLogger\Assistants\AssistantOrgUnit;
use srag\AVL\Plugins\AVLMailLogger\Assistants\AssistantOrgUnitLetter;
use srag\AVL\Plugins\AVLMailLogger\Config\Config;
use srag\AVL\Plugins\AVLMailLogger\Utils\AVLMailLoggerTrait;
use srag\DIC\DICTrait;

/**
 * Class Access
 *
 * @package srag\AVL\Plugins\AVLMailLogger\Access
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Access {

	use DICTrait;
	use AVLMailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilAVLMailLoggerPlugin::class;
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
	 * Access constructor
	 */
	public function __construct() {

	}
}
