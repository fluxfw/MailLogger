<?php

namespace srag\Plugins\MailLogger\Menu;

use ILIAS\GlobalScreen\Provider\StaticProvider\AbstractStaticPluginMainMenuProvider;
use ilMailLoggerPlugin;
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
			self::dic()->globalScreen()->mainmenu()->topLinkItem(self::dic()->globalScreen()->identification()->plugin(self::plugin()
				->getPluginObject(), $this)->identifier(ilMailLoggerPlugin::PLUGIN_ID))->withTitle(ilMailLoggerPlugin::PLUGIN_NAME)
				->withAction(self::dic()->ctrl()->getLinkTargetByClass([ ilUIPluginRouterGUI::class, LogGUI::class ], LogGUI::CMD_LOG))
				->withAvailableCallable(function () {
					return (self::plugin()->getPluginObject()->isActive());
				})->withVisibilityCallable(function () {
					return self::access()->hasLogAccess();
				})
		];
	}


	/**
	 * @inheritdoc
	 */
	public function getStaticSubItems(): array {
		return [];
	}
}
