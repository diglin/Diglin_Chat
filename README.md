# Diglin_Chat #

This <b>OFFICIAL</b> Magento extension displays the [Zopim](http://bit.ly/1kcTNL5) Chat Widget into your shop. Main advantage of this extension is to configure the chat widget in a fast way directly from your Magento installation and customize it per each store and store view.

Please visit [Zopim](http://bit.ly/1kcTNL5) to create an account.

## Features

This module allows you to integrate the Zopim Chat service into your Magento installation in a quick way. You can sign in into Zopim from Magento backend, it will enable and automatically configure the basic configuration of your Zopim Widget.



Additionally, you can use the advanced configuration to configure all options available from the Zopim Dashboard but directly from your Magento installation and per store view if needed:

- Chat Window theme (color, title, size, position)
- Chat Badge (text, image, color)
- Concierge (title, byline, avatar picture)
- Message Style
- Minimized Chat Button (online and offline messages)

The difference with the official Zopim Chat Module is that here you can define the configuration for each store. It's not possible in the official one and won't be possible unless the developer decide to refactor his code. In the meantime, it respects the Magento programming philosophy.

## Documentation

### Via Magento Connect
- You can install the current stable version via [MagentoConnect](http://www.magentocommerce.com/magento-connect/zopim-chat-unofficial-by-diglin.html)

### Via modman
- Install [modman](https://github.com/colinmollenhour/modman)
- Use the command from your Magento installation folder: `modman clone https://github.com/diglin/Diglin_Chat.git`

### Via Composer
- Install [composer](http://getcomposer.org/download/)
- Create a composer.json into your project like the following sample:

```json
{
    ...
    "require": {
        "diglin/diglin_chat":"*"
    },
    "repositories": [
	    {
            "type": "composer",
            "url": "http://packages.firegento.com"
        }
    ],
    "extra":{
        "magento-root-dir": "./"
    }
}

```

- Then from your composer.json folder: `php composer.phar install` or `composer install`

### Via manually
- You can copy the files from the folders of this repository to the same folders structure of your installation

### Post Installation

If you have an error 404 after install the extension and you get access to the configuration pages, do the followings:

- Clear your cache, see the menu <b>System > Cache Management</b>
- Login and logout from your backend to update the access control
- Or after installation, save again the Administrator Role to get access to the configuration page of this module. Go to your Magento Backend, then Menu <b>System > Permissions > Roles > Administrator</b> and save again this role.
- Just configure the key of your account by signin into your Zopim account from the Magento menu <b>Zopim Chat > Account </b> or go into the Menu <b>System > Configuration > Diglin > Zopim Chat</b>. If you don't have an account, you can get it one directly from the Magento configuration Zopim Chat page, thanks to the link or directly get one from [here](http://bit.ly/1kcTNL5).
To find this key, go into the Zopim Dashboard then click on "Widget" in the sidebar and find the link "Embed Zopim Live Chat Widget. In the area where the html code is generated, you can find after //zopim.com/?xyzbufoisfgsigsgdgjbsk. Copy the text after the question mark '?' to the Magento configuration field for the <b>"Key of your account"</b>.

## Customized template
If you have a customized template, check that you have <b>getChildHtml('before_body_end')</b> in files <b>/frontend/mypackage/mytemplate/template/page/1column.phtml, 2columns-left.phtml, 2columns-right.phtml, 3columns.phtml and empty.phtml</b> after <b>getChildHtml('footer')</b> Eventually you will need to copy the file <b>app/design/frontend/base/default/layout/chat.xml</b> in your layout template.

## Author

* Sylvain Rayé
* [www.diglin.com](http://www.diglin.com)
* [@diglin_](https://twitter.com/diglin_)
* [Follow us on github!](https://github.com/diglin)

