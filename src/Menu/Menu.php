<?php

namespace srag\Plugins\MailLogger\Menu;

use ilAdministrationGUI;
use ilDBConstants;
use ILIAS\GlobalScreen\Scope\MainMenu\Factory\AbstractBaseItem;
use ILIAS\GlobalScreen\Scope\MainMenu\Provider\AbstractStaticMainMenuPluginProvider;
use ILIAS\UI\Component\Symbol\Icon\Standard;
use ilMailLoggerConfigGUI;
use ilMailLoggerPlugin;
use ilObjComponentSettingsGUI;
use ilUIPluginRouterGUI;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Config\ConfigCtrl;
use srag\Plugins\MailLogger\Log\LogGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Menu
 *
 * @package srag\Plugins\MailLogger\Menu
 */
class Menu extends AbstractStaticMainMenuPluginProvider
{

    use DICTrait;
    use MailLoggerTrait;

    const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


    /**
     * @inheritDoc
     */
    public function getStaticSubItems() : array
    {
        $parent = $this->getStaticTopItems()[0];

        self::dic()
            ->ctrl()
            ->setParameterByClass(ilMailLoggerConfigGUI::class, "ref_id", self::dic()
                                                                              ->database()
                                                                              ->queryF('SELECT ref_id FROM object_data INNER JOIN object_reference ON object_data.obj_id=object_reference.obj_id WHERE type=%s',
                                                                                  [ilDBConstants::T_TEXT], ["cmps"])
                                                                              ->fetchAssoc()["ref_id"]);
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "ctype", IL_COMP_SERVICE);
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "cname", "EventHandling");
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "slot_id", "evhk");
        self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "pname", ilMailLoggerPlugin::PLUGIN_NAME);

        return [
            $this->symbol($this->mainmenu->link($this->if->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_log"))->withParent($parent->getProviderIdentification())
                ->withTitle(self::plugin()->translate("log", LogGUI::LANG_MODULE))->withAction(str_replace("\\", "%5C", self::dic()->ctrl()->getLinkTargetByClass([
                    ilUIPluginRouterGUI::class,
                    LogGUI::class
                ], LogGUI::CMD_LIST_LOGS)))->withAvailableCallable(function () : bool {
                    return self::plugin()->getPluginObject()->isActive();
                })->withVisibilityCallable(function () : bool {
                    return self::mailLogger()->access()->hasLogAccess();
                })),
            $this->symbol($this->mainmenu->link($this->if->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_configuration"))
                ->withParent($parent->getProviderIdentification())->withTitle(self::plugin()
                    ->translate("configuration", ConfigCtrl::LANG_MODULE))->withAction(self::dic()->ctrl()->getLinkTargetByClass([
                    ilAdministrationGUI::class,
                    ilObjComponentSettingsGUI::class,
                    ilMailLoggerConfigGUI::class
                ], ilMailLoggerConfigGUI::CMD_CONFIGURE))->withAvailableCallable(function () : bool {
                    return self::plugin()->getPluginObject()->isActive();
                })->withVisibilityCallable(function () : bool {
                    return self::dic()->rbac()->review()->isAssigned(self::dic()->user()->getId(), SYSTEM_ROLE_ID);
                }))
        ];
    }


    /**
     * @inheritDoc
     */
    public function getStaticTopItems() : array
    {
        return [
            $this->symbol($this->mainmenu->topParentItem($this->if->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_top"))->withTitle(self::plugin()
                ->translate("log", LogGUI::LANG_MODULE))->withAvailableCallable(function () : bool {
                return self::plugin()->getPluginObject()->isActive();
            })->withVisibilityCallable(function () : bool {
                return self::mailLogger()->access()->hasLogAccess();
            }))
        ];
    }


    /**
     * @param AbstractBaseItem $entry
     *
     * @return AbstractBaseItem
     */
    protected function symbol(AbstractBaseItem $entry) : AbstractBaseItem
    {
        $entry = $entry->withSymbol(self::dic()->ui()->factory()->symbol()->icon()->standard(Standard::MAIL, ilMailLoggerPlugin::PLUGIN_NAME)->withIsOutlined(true));

        return $entry;
    }
}
