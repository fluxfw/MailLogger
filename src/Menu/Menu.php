<?php

namespace srag\Plugins\MailLogger\Menu;

use ilAdministrationGUI;
use ILIAS\GlobalScreen\Scope\MainMenu\Provider\AbstractStaticPluginMainMenuProvider;
use ilMailLoggerConfigGUI;
use ilMailLoggerPlugin;
use ilObjComponentSettingsGUI;
use ilUIPluginRouterGUI;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\CtrlMainMenu\Entry\ctrlmmEntry;
use srag\Plugins\CtrlMainMenu\EntryTypes\Ctrl\ctrlmmEntryCtrl;
use srag\Plugins\CtrlMainMenu\Menu\ctrlmmMenu;
use srag\Plugins\MailLogger\Access\Access;
use srag\Plugins\MailLogger\Log\LogGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;
use Throwable;

/**
 * Class Menu
 *
 * @package srag\Plugins\MailLogger\Menu
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @since   ILIAS 5.4
 */
class Menu extends AbstractStaticPluginMainMenuProvider
{

    use DICTrait;
    use MailLoggerTrait;
    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


    /**
     * @inheritdoc
     */
    public function getStaticTopItems() : array
    {
        return [
            $this->mainmenu->topParentItem($this->if->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_top"))->withTitle(self::plugin()
                ->translate("log", LogGUI::LANG_MODULE_LOG))->withAvailableCallable(function () : bool {
                return self::plugin()->getPluginObject()->isActive();
            })->withVisibilityCallable(function () : bool {
                return self::access()->hasLogAccess();
            })
        ];
    }


    /**
     * @inheritdoc
     */
    public function getStaticSubItems() : array
    {
        $parent = $this->getStaticTopItems()[0];

        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "ref_id", 31);
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "ctype", IL_COMP_SERVICE);
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "cname", "EventHandling");
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "slot_id", "evh");
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "pname", ilMailLoggerPlugin::PLUGIN_NAME);

        return [
            $this->mainmenu->link($this->if->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_log"))->withParent($parent->getProviderIdentification())
                ->withTitle(self::plugin()->translate("log", LogGUI::LANG_MODULE_LOG))->withAction(self::dic()->ctrl()->getLinkTargetByClass([
                    ilUIPluginRouterGUI::class,
                    LogGUI::class
                ], LogGUI::CMD_LOG))->withAvailableCallable(function () : bool {
                    return self::plugin()->getPluginObject()->isActive();
                })->withVisibilityCallable(function () : bool {
                    return self::access()->hasLogAccess();
                }),
            $this->mainmenu->link($this->if->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_configuration"))
                ->withParent($parent->getProviderIdentification())->withTitle(self::plugin()
                    ->translate("configuration", ilMailLoggerConfigGUI::LANG_MODULE_CONFIG))->withAction(self::dic()->ctrl()->getLinkTargetByClass([
                    ilAdministrationGUI::class,
                    ilObjComponentSettingsGUI::class,
                    ilMailLoggerConfigGUI::class
                ], ""))->withAvailableCallable(function () : bool {
                    return self::plugin()->getPluginObject()->isActive();
                })->withVisibilityCallable(function () : bool {
                    return self::dic()->rbacreview()->isAssigned(self::dic()->user()->getId(), 2); // Default admin role
                })
        ];
    }


    /**
     * @deprecated
     */
    public static function addCtrlMainMenu()/*: void*/
    {
        try {
            include_once __DIR__ . "/../../../../../UIComponent/UserInterfaceHook/CtrlMainMenu/vendor/autoload.php";

            if (class_exists(ctrlmmEntry::class)) {
                if (count(ctrlmmEntry::getEntriesByCmdClass(str_replace("\\", "\\\\", LogGUI::class))) === 0) {
                    $entry = new ctrlmmEntryCtrl();
                    $entry->setTitle(ilMailLoggerPlugin::PLUGIN_NAME);
                    $entry->setTranslations([
                        "en" => self::plugin()->translate("log", LogGUI::LANG_MODULE_LOG, [], true, "en"),
                        "de" => self::plugin()->translate("log", LogGUI::LANG_MODULE_LOG, [], true, "de")
                    ]);
                    $entry->setGuiClass(implode(",", [ilUIPluginRouterGUI::class, LogGUI::class]));
                    $entry->setCmd(LogGUI::CMD_LOG);
                    $entry->setPermissionType(ctrlmmMenu::PERM_SCRIPT);
                    $entry->setPermission(json_encode([
                        __DIR__ . "/../vendor/autoload.php",
                        Access::class,
                        "hasLogAccess"
                    ]));
                    $entry->store();
                }
            }
        } catch (Throwable $ex) {
        }
    }


    /**
     * @deprecated
     */
    public static function removeCtrlMainMenu()/*: void*/
    {
        try {
            include_once __DIR__ . "/../../../../../UIComponent/UserInterfaceHook/CtrlMainMenu/vendor/autoload.php";

            if (class_exists(ctrlmmEntry::class)) {
                foreach (ctrlmmEntry::getEntriesByCmdClass(str_replace("\\", "\\\\", LogGUI::class)) as $entry) {
                    /**
                     * @var ctrlmmEntry $entry
                     */
                    $entry->delete();
                }
            }
        } catch (Throwable $ex) {
        }
    }
}
