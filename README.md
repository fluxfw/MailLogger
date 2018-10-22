## Installation

### Install MailLogger-Plugin
Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
cd Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
git clone https://github.com/studer-raimann/MailLogger.git MailLogger
```
Update, activate and config the plugin in the ILIAS Plugin Administration

### Dependencies
* ILIAS 5.3
* PHP >=7.0
* [composer](https://getcomposer.org)
* [srag/activerecordconfig](https://packagist.org/packages/srag/activerecordconfig)
* [srag/dic](https://packagist.org/packages/srag/dic)
* [srag/removeplugindataconfirm](https://packagist.org/packages/srag/removeplugindataconfirm)

Please use it for further development!

### Adjustment suggestions
* Adjustment suggestions by pull requests on https://git.studer-raimann.ch/ILIAS/Plugins/MailLogger/tree/develop
* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/AVL
* Bug reports under https://jira.studer-raimann.ch/projects/AVL
* For external developers please send an email to support-custom1@studer-raimann.ch

### Development
If you want development in this plugin you should install this plugin like follow:

Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
cd Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
git clone -b develop git@git.studer-raimann.ch:ILIAS/Plugins/MailLogger.git MailLogger
```
