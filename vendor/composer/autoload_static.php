<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbc7b400c4e711f828557f7bd975f042c
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'srag\\RemovePluginDataConfirm\\MailLogger\\' => 40,
            'srag\\LibrariesNamespaceChanger\\' => 31,
            'srag\\DIC\\MailLogger\\' => 20,
            'srag\\CustomInputGUIs\\' => 21,
            'srag\\ActiveRecordConfig\\MailLogger\\' => 35,
            'srag\\AVL\\Plugins\\MailLogger\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'srag\\RemovePluginDataConfirm\\MailLogger\\' => 
        array (
            0 => __DIR__ . '/..' . '/srag/removeplugindataconfirm/src',
        ),
        'srag\\LibrariesNamespaceChanger\\' => 
        array (
            0 => __DIR__ . '/..' . '/srag/librariesnamespacechanger/src',
        ),
        'srag\\DIC\\MailLogger\\' => 
        array (
            0 => __DIR__ . '/..' . '/srag/dic/src',
        ),
        'srag\\CustomInputGUIs\\' => 
        array (
            0 => __DIR__ . '/..' . '/srag/custominputguis/src',
        ),
        'srag\\ActiveRecordConfig\\MailLogger\\' => 
        array (
            0 => __DIR__ . '/..' . '/srag/activerecordconfig/src',
        ),
        'srag\\AVL\\Plugins\\MailLogger\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'MailLoggerLogGUI' => __DIR__ . '/../..' . '/classes/Log/class.MailLoggerLogGUI.php',
        'MailLoggerRemoveDataConfirm' => __DIR__ . '/../..' . '/classes/uninstall/class.MailLoggerRemoveDataConfirm.php',
        'ilMailLoggerConfigGUI' => __DIR__ . '/../..' . '/classes/class.ilMailLoggerConfigGUI.php',
        'ilMailLoggerPlugin' => __DIR__ . '/../..' . '/classes/class.ilMailLoggerPlugin.php',
        'srag\\AVL\\Plugins\\MailLogger\\Access\\Access' => __DIR__ . '/../..' . '/src/Access/Access.php',
        'srag\\AVL\\Plugins\\MailLogger\\Access\\Ilias' => __DIR__ . '/../..' . '/src/Access/Ilias.php',
        'srag\\AVL\\Plugins\\MailLogger\\Access\\Users' => __DIR__ . '/../..' . '/src/Access/Users.php',
        'srag\\AVL\\Plugins\\MailLogger\\Config\\Config' => __DIR__ . '/../..' . '/src/Config/Config.php',
        'srag\\AVL\\Plugins\\MailLogger\\Config\\ConfigFormGUI' => __DIR__ . '/../..' . '/src/Config/ConfigFormGUI.php',
        'srag\\AVL\\Plugins\\MailLogger\\Log\\Log' => __DIR__ . '/../..' . '/src/Log/Log.php',
        'srag\\AVL\\Plugins\\MailLogger\\Log\\LogDetailsFormGUI' => __DIR__ . '/../..' . '/src/Log/LogDetailsFormGUI.php',
        'srag\\AVL\\Plugins\\MailLogger\\Log\\LogHandler' => __DIR__ . '/../..' . '/src/Log/LogHandler.php',
        'srag\\AVL\\Plugins\\MailLogger\\Log\\LogTableGUI' => __DIR__ . '/../..' . '/src/Log/LogTableGUI.php',
        'srag\\AVL\\Plugins\\MailLogger\\Logs\\Logs' => __DIR__ . '/../..' . '/src/Log/Logs.php',
        'srag\\AVL\\Plugins\\MailLogger\\Utils\\MailLoggerTrait' => __DIR__ . '/../..' . '/src/Utils/MailLoggerTrait.php',
        'srag\\ActiveRecordConfig\\MailLogger\\ActiveRecordConfig' => __DIR__ . '/..' . '/srag/activerecordconfig/src/ActiveRecordConfig.php',
        'srag\\ActiveRecordConfig\\MailLogger\\ActiveRecordConfigFormGUI' => __DIR__ . '/..' . '/srag/activerecordconfig/src/ActiveRecordConfigFormGUI.php',
        'srag\\ActiveRecordConfig\\MailLogger\\ActiveRecordConfigGUI' => __DIR__ . '/..' . '/srag/activerecordconfig/src/ActiveRecordConfigGUI.php',
        'srag\\ActiveRecordConfig\\MailLogger\\ActiveRecordConfigTableGUI' => __DIR__ . '/..' . '/srag/activerecordconfig/src/ActiveRecordConfigTableGUI.php',
        'srag\\ActiveRecordConfig\\MailLogger\\Exception\\ActiveRecordConfigException' => __DIR__ . '/..' . '/srag/activerecordconfig/src/Exception/ActiveRecordConfigException.php',
        'srag\\CustomInputGUIs\\MailLogger\\DateDurationInputGUI\\DateDurationInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/DateDurationInputGUI/DateDurationInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\GlyphGUI\\GlyphGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/GlyphGUI/GlyphGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\MultiLineInputGUI\\MultiLineInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/MultiLineInputGUI/MultiLineInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\MultiSelectSearchInputGUI\\MultiSelectSearchInput2GUI' => __DIR__ . '/..' . '/srag/custominputguis/src/MultiSelectSearchInputGUI/MultiSelectSearchInput2GUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\MultiSelectSearchInputGUI\\MultiSelectSearchInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/MultiSelectSearchInputGUI/MultiSelectSearchInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\NumberInputGUI\\NumberInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/NumberInputGUI/NumberInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\PropertyFormGUI\\BasePropertyFormGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/PropertyFormGUI/BasePropertyFormGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\PropertyFormGUI\\Exception\\PropertyFormGUIException' => __DIR__ . '/..' . '/srag/custominputguis/src/PropertyFormGUI/Exception/PropertyFormGUIException.php',
        'srag\\CustomInputGUIs\\MailLogger\\PropertyFormGUI\\PropertyFormGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/PropertyFormGUI/PropertyFormGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\ScreenshotsInputGUI\\ScreenshotsInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/ScreenshotsInputGUI/ScreenshotsInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\StaticHTMLPresentationInputGUI\\StaticHTMLPresentationInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/StaticHTMLPresentationInputGUI/StaticHTMLPresentationInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\Template\\Template' => __DIR__ . '/..' . '/srag/custominputguis/src/Template/Template.php',
        'srag\\CustomInputGUIs\\MailLogger\\TextAreaInputGUI\\TextAreaInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/TextAreaInputGUI/TextAreaInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\TextInputGUI\\TextInputGUI' => __DIR__ . '/..' . '/srag/custominputguis/src/TextInputGUI/TextInputGUI.php',
        'srag\\CustomInputGUIs\\MailLogger\\Waiter\\Waiter' => __DIR__ . '/..' . '/srag/custominputguis/src/Waiter/Waiter.php',
        'srag\\DIC\\MailLogger\\DICStatic' => __DIR__ . '/..' . '/srag/dic/src/DICStatic.php',
        'srag\\DIC\\MailLogger\\DICStaticInterface' => __DIR__ . '/..' . '/srag/dic/src/DICStaticInterface.php',
        'srag\\DIC\\MailLogger\\DICTrait' => __DIR__ . '/..' . '/srag/dic/src/DICTrait.php',
        'srag\\DIC\\MailLogger\\DIC\\AbstractDIC' => __DIR__ . '/..' . '/srag/dic/src/DIC/AbstractDIC.php',
        'srag\\DIC\\MailLogger\\DIC\\DICInterface' => __DIR__ . '/..' . '/srag/dic/src/DIC/DICInterface.php',
        'srag\\DIC\\MailLogger\\DIC\\LegacyDIC' => __DIR__ . '/..' . '/srag/dic/src/DIC/LegacyDIC.php',
        'srag\\DIC\\MailLogger\\DIC\\NewDIC' => __DIR__ . '/..' . '/srag/dic/src/DIC/NewDIC.php',
        'srag\\DIC\\MailLogger\\Exception\\DICException' => __DIR__ . '/..' . '/srag/dic/src/Exception/DICException.php',
        'srag\\DIC\\MailLogger\\Plugin\\Plugin' => __DIR__ . '/..' . '/srag/dic/src/Plugin/Plugin.php',
        'srag\\DIC\\MailLogger\\Plugin\\PluginInterface' => __DIR__ . '/..' . '/srag/dic/src/Plugin/PluginInterface.php',
        'srag\\DIC\\MailLogger\\Plugin\\Pluginable' => __DIR__ . '/..' . '/srag/dic/src/Plugin/Pluginable.php',
        'srag\\DIC\\MailLogger\\Version\\Version' => __DIR__ . '/..' . '/srag/dic/src/Version/Version.php',
        'srag\\DIC\\MailLogger\\Version\\VersionInterface' => __DIR__ . '/..' . '/srag/dic/src/Version/VersionInterface.php',
        'srag\\LibrariesNamespaceChanger\\LibrariesNamespaceChanger' => __DIR__ . '/..' . '/srag/librariesnamespacechanger/src/LibrariesNamespaceChanger.php',
        'srag\\RemovePluginDataConfirm\\MailLogger\\AbstractPluginUninstallTrait' => __DIR__ . '/..' . '/srag/removeplugindataconfirm/src/AbstractPluginUninstallTrait.php',
        'srag\\RemovePluginDataConfirm\\MailLogger\\AbstractRemovePluginDataConfirm' => __DIR__ . '/..' . '/srag/removeplugindataconfirm/src/AbstractRemovePluginDataConfirm.php',
        'srag\\RemovePluginDataConfirm\\MailLogger\\PluginUninstallTrait' => __DIR__ . '/..' . '/srag/removeplugindataconfirm/src/PluginUninstallTrait.php',
        'srag\\RemovePluginDataConfirm\\MailLogger\\RemovePluginDataConfirmException' => __DIR__ . '/..' . '/srag/removeplugindataconfirm/src/RemovePluginDataConfirmException.php',
        'srag\\RemovePluginDataConfirm\\MailLogger\\RepositoryObjectPluginUninstallTrait' => __DIR__ . '/..' . '/srag/removeplugindataconfirm/src/RepositoryObjectPluginUninstallTrait.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbc7b400c4e711f828557f7bd975f042c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbc7b400c4e711f828557f7bd975f042c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbc7b400c4e711f828557f7bd975f042c::$classMap;

        }, null, ClassLoader::class);
    }
}
