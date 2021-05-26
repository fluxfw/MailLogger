<?php

namespace srag\DIC\MailLogger\Plugin;

/**
 * Interface Pluginable
 *
 * @package srag\DIC\MailLogger\Plugin
 */
interface Pluginable
{

    /**
     * @return PluginInterface
     */
    public function getPlugin() : PluginInterface;


    /**
     * @param PluginInterface $plugin
     *
     * @return static
     */
    public function withPlugin(PluginInterface $plugin)/*: static*/ ;
}
