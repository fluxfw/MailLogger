<?php

namespace srag\Plugins\MailLogger\Log\Form;

use ilDatePresentation;
use ilDateTime;
use ilMailLoggerPlugin;
use ilNonEditableValueGUI;
use srag\CustomInputGUIs\MailLogger\FormBuilder\AbstractFormBuilder;
use srag\CustomInputGUIs\MailLogger\InputGUIWrapperUIInputComponent\InputGUIWrapperUIInputComponent;
use srag\CustomInputGUIs\MailLogger\StaticHTMLPresentationInputGUI\StaticHTMLPresentationInputGUI;
use srag\Plugins\MailLogger\Log\Log;
use srag\Plugins\MailLogger\Log\LogGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class FormBuilder
 *
 * @package srag\Plugins\MailLogger\Log\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class FormBuilder extends AbstractFormBuilder
{

    use MailLoggerTrait;

    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    /**
     * @var Log
     */
    protected $log;


    /**
     * @inheritDoc
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
    protected function getButtons() : array
    {
        $buttons = [];

        return $buttons;
    }


    /**
     * @inheritDoc
     */
    protected function getData() : array
    {
        $data = [
            "from"      => $this->log->getFromFirstname() . " " . $this->log->getFromLastname() . " <" . $this->log->getFromEmail() . ">",
            "subject"   => $this->log->getSubject(),
            "timestamp" => ilDatePresentation::formatDate(new ilDateTime($this->log->getTimestamp(), IL_CAL_UNIX)),
            "to"        => $this->log->getToFirstname() . " " . $this->log->getToLastname() . " <" . $this->log->getToEmail() . ">"
        ];

        return $data;
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        $fields = [
            "from"      => new InputGUIWrapperUIInputComponent(new ilNonEditableValueGUI(self::plugin()->translate("from", LogGUI::LANG_MODULE))),
            "subject"   => new InputGUIWrapperUIInputComponent(new ilNonEditableValueGUI(self::plugin()->translate("subject", LogGUI::LANG_MODULE))),
            "timestamp" => new InputGUIWrapperUIInputComponent(new ilNonEditableValueGUI(self::plugin()->translate("timestamp", LogGUI::LANG_MODULE))),
            "to"        => new InputGUIWrapperUIInputComponent(new ilNonEditableValueGUI(self::plugin()->translate("to", LogGUI::LANG_MODULE))),
            "header"    => self::dic()->ui()->factory()->input()->field()->section([
                "body" => new InputGUIWrapperUIInputComponent($html = new StaticHTMLPresentationInputGUI(self::plugin()->translate("body", LogGUI::LANG_MODULE)))
            ], $this->log->getSubject())
        ];
        $html->setHtml($this->log->getBody());

        return $fields;
    }


    /**
     * @inheritDoc
     */
    protected function getTitle() : string
    {
        return "";
    }


    /**
     * @inheritDoc
     */
    protected function storeData(array $data)/* : void*/
    {

    }
}
