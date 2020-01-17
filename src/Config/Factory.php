<?php

namespace srag\Plugins\MailLogger\Config;

use ilMailLoggerConfigGUI;
use ilMailLoggerPlugin;
use srag\ActiveRecordConfig\MailLogger\Config\AbstractFactory;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Factory
 *
 * @package srag\Plugins\MailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Factory extends AbstractFactory
{

    use MailLoggerTrait;
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    /**
     * @var self
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
        parent::__construct();
    }


    /**
     * @param ilMailLoggerConfigGUI $parent
     *
     * @return ConfigFormGUI
     */
    public function newFormInstance(ilMailLoggerConfigGUI $parent) : ConfigFormGUI
    {
        $form = new ConfigFormGUI($parent);

        return $form;
    }
}
