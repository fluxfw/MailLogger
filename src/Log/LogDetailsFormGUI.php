<?php

namespace srag\AVL\Plugins\MailLogger\Log;

use ilDatePresentation;
use ilDateTime;
use ilFormSectionHeaderGUI;
use ilMailLoggerPlugin;
use ilNonEditableValueGUI;
use ilPropertyFormGUI;
use MailLoggerLogGUI;
use srag\AVL\Plugins\MailLogger\Utils\MailLoggerTrait;
use srag\CustomInputGUIs\MailLogger\StaticHTMLPresentationInputGUI\StaticHTMLPresentationInputGUI;
use srag\DIC\MailLogger\DICTrait;

/**
 * Class LogDetailsFormGUI
 *
 * @package srag\AVL\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class LogDetailsFormGUI extends ilPropertyFormGUI {

	use DICTrait;
	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
	/**
	 * @var MailLoggerLogGUI
	 */
	protected $parent;
	/**
	 * @var Log
	 */
	protected $log;


	/**
	 * LogDetailsFormGUI constructor
	 *
	 * @param MailLoggerLogGUI $parent
	 * @param Log              $log
	 */
	public function __construct(MailLoggerLogGUI $parent, Log $log) {
		parent::__construct();

		$this->parent = $parent;
		$this->log = $log;

		$this->initForm();
	}


	/**
	 *
	 */
	protected function initForm()/*: void*/ {
		//$this->setTitle(self::plugin()->translate("infos", MailLoggerLogGUI::LANG_MODULE_LOG));

		$from_email = new ilNonEditableValueGUI(self::plugin()->translate("from", MailLoggerLogGUI::LANG_MODULE_LOG));
		$from_email->setValue($this->log->getFromFirstname() . " " . $this->log->getFromLastname() . " <" . $this->log->getFromEmail() . ">");
		$this->addItem($from_email);

		$subject = new ilNonEditableValueGUI(self::plugin()->translate("subject", MailLoggerLogGUI::LANG_MODULE_LOG));
		$subject->setValue($this->log->getSubject());
		$this->addItem($subject);

		$timestamp = new ilNonEditableValueGUI(self::plugin()->translate("timestamp", MailLoggerLogGUI::LANG_MODULE_LOG));
		$timestamp->setValue(ilDatePresentation::formatDate(new ilDateTime($this->log->getTimestamp(), IL_CAL_UNIX)));
		$this->addItem($timestamp);

		$to_email = new ilNonEditableValueGUI(self::plugin()->translate("to", MailLoggerLogGUI::LANG_MODULE_LOG));
		$to_email->setValue($this->log->getToFirstname() . " " . $this->log->getToLastname() . " <" . $this->log->getToEmail() . ">");
		$this->addItem($to_email);

		$header = new ilFormSectionHeaderGUI();
		$header->setTitle($this->log->getSubject());
		$this->addItem($header);

		$body = new StaticHTMLPresentationInputGUI(self::plugin()->translate("body", MailLoggerLogGUI::LANG_MODULE_LOG));
		$body->setHtml($this->log->getBody());
		$this->addItem($body);
	}
}
