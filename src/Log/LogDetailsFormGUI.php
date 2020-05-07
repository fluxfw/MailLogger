<?php

namespace srag\Plugins\MailLogger\Log;

use ilDatePresentation;
use ilDateTime;
use ilFormSectionHeaderGUI;
use ilMailLoggerPlugin;
use ilNonEditableValueGUI;
use srag\CustomInputGUIs\MailLogger\PropertyFormGUI\PropertyFormGUI;
use srag\CustomInputGUIs\MailLogger\StaticHTMLPresentationInputGUI\StaticHTMLPresentationInputGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class LogDetailsFormGUI
 *
 * @package srag\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class LogDetailsFormGUI extends PropertyFormGUI
{

    use MailLoggerTrait;

    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    const LANG_MODULE = LogGUI::LANG_MODULE;
    /**
     * @var Log
     */
    protected $log;


    /**
     * LogDetailsFormGUI constructor
     *
     * @param LogGUI $parent
     * @param Log    $log
     */
    public function __construct(LogGUI $parent, Log $log)
    {
        $this->log = $log;

        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/
        $key
    )/*: void*/
    {
        switch ($key) {
            case "from":
                return $this->log->getFromFirstname() . " " . $this->log->getFromLastname() . " <" . $this->log->getFromEmail() . ">";

            case "subject":
                return $this->log->getSubject();

            case "timestamp":
                return ilDatePresentation::formatDate(new ilDateTime($this->log->getTimestamp(), IL_CAL_UNIX));

            case "to":
                return $this->log->getToFirstname() . " " . $this->log->getToLastname() . " <" . $this->log->getToEmail() . ">";

            default:
                break;
        }

        return null;
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            "from"      => [
                self::PROPERTY_CLASS => ilNonEditableValueGUI::class
            ],
            "subject"   => [
                self::PROPERTY_CLASS => ilNonEditableValueGUI::class
            ],
            "timestamp" => [
                self::PROPERTY_CLASS => ilNonEditableValueGUI::class
            ],
            "to"        => [
                self::PROPERTY_CLASS => ilNonEditableValueGUI::class
            ],
            "header"    => [
                self::PROPERTY_CLASS => ilFormSectionHeaderGUI::class,
                "setTitle"           => $this->log->getSubject()
            ],
            "body"      => [
                self::PROPERTY_CLASS => StaticHTMLPresentationInputGUI::class,
                "setHtml"            => $this->log->getBody()
            ]
        ];
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        //$this->setTitle(self::plugin()->translate("infos", self::LANG_MODULE));
    }


    /**
     * @inheritDoc
     */
    public function storeForm() : bool
    {
        return false;
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/
        $key,
        $value
    )/*: void*/
    {

    }
}
