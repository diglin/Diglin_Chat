# Diglin_Chat #

This is a Magento module to display the Zopim Chat Widget into the shop. Advantage of this module is to configure the chat window per each store and store view. Please visit [Zopim](http://www.zopim.com/affiliates/landing/rissip) to create an account and get a key.

## Features

This module allows you to integrate the Zopim chat service into your Magento installation. You can get access to the Zopim Dashboard directly from the Magento backend. This module allows you to configure for each store view:

- Text for the bubble and the chat bar/panel
- Display or not by default some chat elements (bubble, window, button)
- Define and color (depending on Zopim package paid)
- Show unread flag icon if enabled
- Display the name and email of the logged customer
- Define where to place the button (bottom left or right) and/or set an offset
- Automatically or not, set the language of the chat (based on Magento locale or not)
- Add the new API call for faster loading page (you have to enable it in the configuration chat page into Magento backend)

The difference with the official Zopim Chat Module is that here you can define the configuration for each store. It's not possible in the official one and won't be possible unless the developer decide to refactor his code. In the meantime, it respects the Magento programming philosophy.

## Documentation

### Via Magento Connect
- You can install the current stable version via [MagentoConnect](http://www.magentocommerce.com/magento-connect/zopim-chat-unofficial-by-diglin.html)

### Via modman
- Install [modman](https://github.com/colinmollenhour/modman)
- Use the command from your Magento installation folder: `modman clone https://github.com/diglin/Diglin_Chat.git`

### Manually
- You can copy the files from the folders of this repository to the same folders of your installation

### Post Installation
- After installation, save again the Administrator Role to get access to the configuration page of this module. Go to your Magento Backend, then Menu System > Permissions > Roles > Administrator and save again this role.
- Just configure the key of your account in Menu System > Configuration > Diglin > Zopim Chat. If you don't have one, you can get it one directly from the Magento configuration Zopim Chat page, thanks to the link. If you don't have an account, you can click here to get one. To find this key, go into the Zopim Dashboard then click on Setting and find the link "Embed widget on my site". In the area where the html code is generated, you can find after //zopim.com/?xyzbufoisfgsigsgdgjbsk. Copy the text after the question mark to the Magento configuration field for the "Key of your account".
- If you have a customized template, check that you have getChildHtml('before_body_end') ?> in files /frontend/default/mytemplate/template/page/1column.phtml, 2columns-left.phtml, 2columns-right.phtml, 3columns.phtml and empty.phtml after getChildHtml('footer') ?> Eventually you will need to copy the file app/design/frontend/default/default/layout/chat.xml in your layout template.

## Author

* Sylvain Rayé
* http://www.sylvainraye.com/
* [@sylvainraye](https://twitter.com/sylvainraye)
* [Follow me on github!](https://github.com/diglin)

## Donation

[Invite me for a drink](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y66QHLU5VX5BC)