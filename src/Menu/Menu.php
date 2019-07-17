<?php

namespace srag\Plugins\MailLogger\Menu;

use ilAdministrationGUI;
use ILIAS\GlobalScreen\Scope\MainMenu\Provider\AbstractStaticPluginMainMenuProvider;
use ilMailLoggerConfigGUI;
use ilMailLoggerPlugin;
use ilObjComponentSettingsGUI;
use ilUIPluginRouterGUI;
use srag\DIC\MailLogger\DICTrait;
use srag\Plugins\MailLogger\Log\LogGUI;
use srag\Plugins\MailLogger\Utils\MailLoggerTrait;

/**
 * Class Menu
 *
 * @package srag\Plugins\MailLogger\Menu
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @since   ILIAS 5.4
 */
class Menu extends AbstractStaticPluginMainMenuProvider {

	use DICTrait;
	use MailLoggerTrait;
	const PLUGIN_CLASS_NAME = ilMailLoggerPlugin::class;


	/**
	 * @inheritdoc
	 */
	public function getStaticTopItems(): array {
		return [
			self::dic()->globalScreen()->mainmenu()->topParentItem(self::dic()->globalScreen()->identification()->plugin(self::plugin()
				->getPluginObject(), $this)->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_top"))->withTitle(self::plugin()
				->translate("log", LogGUI::LANG_MODULE_LOG))->withAvailableCallable(function (): bool {
				return self::plugin()->getPluginObject()->isActive();
			})->withVisibilityCallable(function (): bool {
				return self::access()->hasLogAccess();
			})
		];
	}


	/**
	 * @inheritdoc
	 */
	public function getStaticSubItems(): array {
		$parent = $this->getStaticTopItems()[0];

		self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "ref_id", 31);
		self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "ctype", IL_COMP_SERVICE);
		self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "cname", "EventHandling");
		self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "slot_id", "evh");
		self::dic()->ctrl()->setParameterByClass(ilMailLoggerConfigGUI::class, "pname", ilMailLoggerPlugin::PLUGIN_NAME);

		return [
			self::dic()->globalScreen()->mainmenu()->link(self::dic()->globalScreen()->identification()->plugin(self::plugin()
				->getPluginObject(), $this)->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_log"))->withParent($parent->getProviderIdentification())
				->withTitle(self::plugin()->translate("log", LogGUI::LANG_MODULE_LOG))->withAction(self::dic()->ctrl()->getLinkTargetByClass([
					ilUIPluginRouterGUI::class,
					LogGUI::class
				], LogGUI::CMD_LOG))->withAvailableCallable(function (): bool {
					return self::plugin()->getPluginObject()->isActive();
				})->withVisibilityCallable(function (): bool {
					return self::access()->hasLogAccess();
				}),
			self::dic()->globalScreen()->mainmenu()->link(self::dic()->globalScreen()->identification()->plugin(self::plugin()
				->getPluginObject(), $this)->identifier(ilMailLoggerPlugin::PLUGIN_ID . "_configuration"))
				->withParent($parent->getProviderIdentification())->withTitle(self::plugin()
					->translate("configuration", ilMailLoggerConfigGUI::LANG_MODULE_CONFIG))->withAction(self::dic()->ctrl()->getLinkTargetByClass([
					ilAdministrationGUI::class,
					ilObjComponentSettingsGUI::class,
					ilMailLoggerConfigGUI::class
				], ""))->withAvailableCallable(function (): bool {
					return self::plugin()->getPluginObject()->isActive();
				})->withVisibilityCallable(function (): bool {
					return self::dic()->rbacreview()->isAssigned(self::dic()->user()->getId(), 2); // Default admin role
				})
		];
	}
}
