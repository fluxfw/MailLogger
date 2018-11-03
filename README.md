## Installation

### Install MailLogger-Plugin
Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
cd Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
git clone https://github.com/studer-raimann/MailLogger.git MailLogger
```
Update, activate and config the plugin in the ILIAS Plugin Administration

### ILIAS-Core-Patch
In order for log sending emails correctly, it needs some patches in the ILIAS core:

1. Event for send internal emails:
`Services/Mail/classes/class.ilMail.php::sendInternalMail`:
```php
...
class ilMimeMail
{
	...
	public function sendInternalMail(
    		$a_folder_id, $a_sender_id, $a_attachments, $a_rcp_to, $a_rcp_cc, $a_rcp_bcc,
    		$a_status, $a_m_type, $a_m_email, $a_m_subject, $a_m_message, $a_user_id = 0,
    		$a_use_placeholders = 0, $a_tpl_context_id = null, $a_tpl_context_params = array()
    	)
    	{
    	...
		//PATCH MailLogger Event for send internal emails
		$mbox = new ilMailbox();
        $mbox->setUserId($a_user_id);
        //Only save outgoing mails not mails saved in sent folder
        if($mbox->getSentFolder() != $a_folder_id) {
			global $DIC;
			$DIC->event()->raise("Services/Mail", "sendInternalEmail", [
				"subject" => $a_m_subject,
				"body" => $a_m_message,
				"is_system" => in_array("system", $a_m_type),
				"from_user_id" => $a_sender_id,
				"to_user_id" => $a_user_id,
				"context_ref_id" => $a_tpl_context_id
			]);
		}
		//PATCH MailLogger

		return $next_id;
    }
    	...
}
```
2. Event for send external emails:
`Services/Mail/classes/Mime/Transport/class.ilMailMimeTransportBase.php::send`:
```php
...
abstract class ilMailMimeTransportBase implements ilMailMimeTransport
{
	...
	final public function send(ilMimeMail $mail)
		...
		if($result)
		{
			ilLoggerFactory::getLogger('mail')->debug(sprintf(
				'Successfully delegated external mail delivery'
			));
		
			//PATCH MailLogger Event for send external emails:
			global $DIC;
			$DIC->event()->raise("Services/Mail", "sendExternalEmail", [ "mail" => $mail ]);
			//PATCH MailLogger
		}
		else
			ilLoggerFactory::getLogger('mail')->warning(sprintf(
				'Could not deliver external email: %s', $this->getMailer()->ErrorInfo
			));
		}

		return $result;
	}
}
```

### Some screenshots
TODO

### Dependencies
* ILIAS 5.3
* PHP >=7.0
* [composer](https://getcomposer.org)
* [CtrlMainMenu](https://github.com/studer-raimann/CtrlMainMenu)
* [srag/activerecordconfig](https://packagist.org/packages/srag/activerecordconfig)
* [srag/custominputguis](https://packagist.org/packages/srag/custominputguis)
* [srag/dic](https://packagist.org/packages/srag/dic)
* [srag/removeplugindataconfirm](https://packagist.org/packages/srag/removeplugindataconfirm)

Please use it for further development!

### Adjustment suggestions
* Adjustment suggestions by pull requests on https://git.studer-raimann.ch/ILIAS/Plugins/MailLogger/tree/develop
* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/AVL
* Bug reports under https://jira.studer-raimann.ch/projects/AVL
* For external users please send an email to support-custom1@studer-raimann.ch

### Development
If you want development in this plugin you should install this plugin like follow:

Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
cd Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
git clone -b develop git@git.studer-raimann.ch:ILIAS/Plugins/MailLogger.git MailLogger
```
