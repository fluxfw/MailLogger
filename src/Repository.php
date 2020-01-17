<?php

namespace srag\Plugins\MailLogger;

use ilMailLoggerPlugin;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Access\Access;
use srag\Plugins\MailLogger\Access\Ilias;
use srag\Plugins\MailLogger\Config\Repository as ConfigRepository;
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

    }


    /**
     * @return Access
     */
    public function access() : Access
    {
        return Access::getInstance();
    }


    /**
     * @return ConfigRepository
     */
    public function config() : ConfigRepository
    {
        return ConfigRepository::getInstance();
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
