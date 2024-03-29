# MailLogger ILIAS Plugin

Log and view sended mails in ILIAS

This project is licensed under the GPL-3.0-only license

## Requirements

* ILIAS 6.0 - 7.999
* PHP >=7.2

## Installation

Start at your ILIAS root directory

```bash
mkdir -p Customizing/global/plugins/Services/EventHandling/EventHook
cd Customizing/global/plugins/Services/EventHandling/EventHook
git clone https://github.com/fluxfw/MailLogger.git MailLogger
```

Update, activate and config the plugin in the ILIAS Plugin Administration

## Description

Logs mails and displays them in a table

Config:
![Config](./doc/images/config.png)

Send test mail:
![Send test mail](./doc/images/send_test_mail.png)

Log table:
![Log table](./doc/images/log_table.png)

Show email:
![Show email](./doc/images/show_email.png)
