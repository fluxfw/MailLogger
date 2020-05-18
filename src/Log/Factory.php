<?php

namespace srag\Plugins\MailLogger\Log;

use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Log\Form\FormBuilder;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Factory
 *
 * @package srag\Plugins\MailLogger\Log
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Factory
{

    use DICTrait;
    use MailLoggerTrait;

    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @return Log
     */
    public function newInstance() : Log
    {
        $log = new Log();

        return $log;
    }


    /**
     * @param LogGUI $parent
     * @param string $cmd
     *
     * @return LogTableGUI
     */
    public function newTableInstance(LogGUI $parent, string $cmd = LogGUI::CMD_LIST_LOGS) : LogTableGUI
    {
        $table = new LogTableGUI($parent, $cmd);

        return $table;
    }


    /**
     * @param LogGUI $parent
     * @param Log    $log
     *
     * @return FormBuilder
     */
    public function newFormBuilderInstance(LogGUI $parent, Log $log) : FormBuilder
    {
        $form = new FormBuilder($parent, $log);

        return $form;
    }
}
