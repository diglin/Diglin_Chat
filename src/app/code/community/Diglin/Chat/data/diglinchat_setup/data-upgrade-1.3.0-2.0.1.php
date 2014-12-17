<?php
/**
 * Diglin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category    Diglin
 * @package     Diglin_Chat
 * @copyright   Copyright (c) 2011-2015 Diglin (http://www.diglin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $this Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer->startSetup();

$select = $installer->getConnection()->select()
        ->from($this->getTable('core/config_data'))
        ->where('path LIKE "%chat/chatconfig/%"');

$result = $installer->getConnection()->fetchOne($select);

if ($result) {
    $installer->getConnection()->insert($this->getTable('core/config_data'), array('path' => 'chat/widgetconfig/type_config', 'value' => 'adv'));
    $installer->getConnection()->insert($this->getTable('core/config_data'), array('path' => 'chat/widgetconfig/window_theme', 'value' => 'classic'));
    $installer->getConnection()->insert($this->getTable('core/config_data'), array('path' => 'chat/widgetconfig/theme_bubble_color_primary', 'value' => 'bubble_color_customized'));
}

$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/newapicall'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/unreadflag'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/buttonconfig/color'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/windowconfig/theme'");


$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chatconfig/online_greeting_short','widgetconfig/online_message') WHERE path LIKE '%chatconfig/online_greeting_short%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chatconfig/offline_greeting_short','widgetconfig/offline_message') WHERE path LIKE '%chatconfig/offline_greeting_short%'";
$installer->getConnection()->query($query);

$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/online_greeting_short'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/online_greeting_long'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/offline_greeting_short'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/offline_greeting_long'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/away_greeting_short'");
$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/away_greeting_long'");

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'bubbleconfig/color','widgetconfig/theme_bubble_color') WHERE path LIKE '%bubbleconfig/color%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'bubbleconfig/','widgetconfig/bubble_') WHERE path LIKE '%bubbleconfig/%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/buttonconfig/position','chat/widgetconfig/button_position') WHERE path LIKE '%chat/buttonconfig/position%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'buttonconfig/','widgetconfig/button_') WHERE path LIKE '%buttonconfig/%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/windowconfig/theme','chat/widgetconfig/window_theme') WHERE path LIKE '%chat/windowconfig/theme%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/windowconfig/color','chat/widgetconfig/theme_primary_color') WHERE path LIKE '%chat/windowconfig/color%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/chatconfig/disable_sound','chat/widgetconfig/disable_sound') WHERE path LIKE '%chat/chatconfig/disable_sound%'";
$installer->getConnection()->query($query);

Mage::getConfig()->cleanCache();

$installer->endSetup();
