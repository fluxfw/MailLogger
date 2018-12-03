<?php

namespace srag\DIC\MailLogger\Exception;

use ilException;

/**
 * Class DICException
 *
 * @package srag\DIC\MailLogger\Exception
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class DICException extends ilException {

	/**
	 * DICException constructor
	 *
	 * @param string $message
	 * @param int    $code
	 *
	 * @internal
	 */
	public function __construct(/*string*/
		$message, /*int*/
		$code = 0) {
		parent::__construct($message, $code);
	}
}
