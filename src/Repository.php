<?php

namespace srag\Plugins\MailLogger;

use ilMailLoggerPlugin;
use srag\ActiveRecordConfig\MailLogger\Config\Config;
use srag\ActiveRecordConfig\MailLogger\Config\Repository as ConfigRepository;
use srag\ActiveRecordConfig\MailLogger\Utils\ConfigTrait;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Access\Access;
use srag\Plugins\MailLogger\Access\Ilias;
use srag\Plugins\MailLogger\Config\ConfigFormGUI;
use srag\Plugins\MailLogger\Log\Repository as LogsRepository;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Repository
 *
 * @package srag\Plugins\MailLogger
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Repository
{

    use DICTrait;
    use MailLoggerTrait;
    use ConfigTrait {
        config as protected _config;
    }
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
     * Repository constructor
     */
    private function __construct()
    {
        $this->config()->withTableName(ilMailLoggerPlugin::PLUGIN_ID . "_config")->withFields([
            ConfigFormGUI::KEY_LOG_EMAIL_OF_USERS => [Config::TYPE_JSON, []],
            ConfigFormGUI::KEY_LOG_SYSTEM_EMAILS  => Config::TYPE_BOOLEAN
        ]);
    }


    /**
     * @return Access
     */
    public function access() : Access
    {
        return Access::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function config() : ConfigRepository
    {
        return self::_config();
    }


    /**
     *
     */
    public function dropTables()/*: void*/
    {
        $this->config()->dropTables();
        $this->logs()->dropTables();
    }


    /**
     * @return Ilias
     */
    public function ilias() : Ilias
    {
        return Ilias::getInstance();
    }


    /**
     *
     */
    public function installTables()/*: void*/
    {
        $this->config()->installTables();
        $this->logs()->installTables();
    }


    /**
     * @return LogsRepository
     */
    public function logs() : LogsRepository
    {
        return LogsRepository::getInstance();
    }
}
