<?php

namespace srag\RemovePluginDataConfirm\MailLogger;

/**
 * Trait PluginUninstallTrait
 *
 * @package srag\RemovePluginDataConfirm\MailLogger
 */
trait PluginUninstallTrait
{

    use BasePluginUninstallTrait;

    /**
     * @internal
     */
    protected final function afterUninstall() : void
    {

    }


    /**
     * @return bool
     *
     * @internal
     */
    protected final function beforeUninstall() : bool
    {
        return $this->pluginUninstall();
    }
}
