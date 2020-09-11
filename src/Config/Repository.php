<?php

namespace srag\Plugins\MailLogger\Config;

use ilMailLoggerPlugin;
use srag\ActiveRecordConfig\MailLogger\Config\AbstractFactory;
use srag\ActiveRecordConfig\MailLogger\Config\AbstractRepository;
use srag\ActiveRecordConfig\MailLogger\Config\Config;
use srag\Plugins\MailLogger\Config\Form\FormBuilder;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\MailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository extends AbstractRepository
{

    use MailLoggerTrait;

    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * Repository constructor
     */
    protected function __construct()
    {
        parent::__construct();
    }


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
     * @inheritDoc
     *
     * @return Factory
     */
    public function factory() : AbstractFactory
    {
        return Factory::getInstance();
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        return [
            FormBuilder::KEY_LOG_EMAIL_OF_USERS => [Config::TYPE_JSON, []],
            FormBuilder::KEY_LOG_SYSTEM_EMAILS  => Config::TYPE_BOOLEAN
        ];
    }


    /**
     * @inheritDoc
     */
    protected function getTableName() : string
    {
        return ilMailLoggerPlugin::PLUGIN_ID . "_config";
    }
}
