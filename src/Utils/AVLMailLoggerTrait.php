<?php

namespace srag\AVL\Plugins\AVLMailLogger\Utils;

use srag\AVL\Plugins\AVLMailLogger\Access\Access;

/**
 * Trait AVLMailLoggerTrait
 *
 * @package srag\AVL\Plugins\AVLMailLogger\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait AVLMailLoggerTrait {

	/**
	 * @return Access
	 */
	protected static function access(): Access {
		return Access::getInstance();
	}
}
