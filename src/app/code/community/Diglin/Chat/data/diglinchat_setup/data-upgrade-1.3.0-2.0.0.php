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
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Diglin
 * @package     Diglin_Chat
 * @copyright   Copyright (c) 2011-2014 Diglin (http://www.diglin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $this Mage_Core_Model_Resource_Setup */

$installer = $this;

$installer->startSetup();

$installer->getConnection()->delete($this->getTable('core/config_data'), "path='chat/chatconfig/newapicall'");

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chatconfig/online_','widgetconfig/online_') WHERE path LIKE '%chatconfig/online_%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chatconfig/offline_','widgetconfig/offline_') WHERE path LIKE '%chatconfig/offline_%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chatconfig/away_','widgetconfig/away_') WHERE path LIKE '%chatconfig/away_%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chatconfig/unreadflag','widgetconfig/unreadflag') WHERE path LIKE '%chatconfig/unreadflag%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'bubbleconfig/','widgetconfig/bubble_') WHERE path LIKE '%bubbleconfig/%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/buttonconfig/color','chat/widgetconfig/button_offset_horizontal') WHERE path LIKE '%chat/buttonconfig/color%'";

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'buttonconfig/','widgetconfig/button_') WHERE path LIKE '%buttonconfig/%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/windowconfig/theme','chat/widgetconfig/window_theme') WHERE path LIKE '%chat/windowconfig/theme%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/windowconfig/color','chat/widgetconfig/theme_primary_color') WHERE path LIKE '%chat/windowconfig/color%'";
$installer->getConnection()->query($query);

$query = "UPDATE " . $this->getTable('core/config_data') . " SET path=REPLACE(path,'chat/chatconfig/disable_sound','chat/widgetconfig/disable_sound') WHERE path LIKE '%chat/chatconfig/disable_sound%'";
$installer->getConnection()->query($query);

$installer->getConnection()->query($query);

$installer->endSetup();
