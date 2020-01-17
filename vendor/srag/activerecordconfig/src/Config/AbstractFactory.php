<?php

namespace srag\ActiveRecordConfig\MailLogger\Config;

use srag\DIC\MailLogger\DICTrait;

/**
 * Class AbstractFactory
 *
 * @package srag\ActiveRecordConfig\MailLogger\Config
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractFactory
{

    use DICTrait;


    /**
     * AbstractFactory constructor
     */
    protected function __construct()
    {

    }


    /**
     * @return Config
     */
    public function newInstance() : Config
    {
        $config = new Config();

        return $config;
    }
}
