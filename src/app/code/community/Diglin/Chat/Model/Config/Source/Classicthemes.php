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

class Diglin_Chat_Model_Config_Source_Classicthemes
{
    /**
     * Options getter
     *
     * @deprecated
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => '', 'label' => Mage::helper('chat')->__('-- Please Select (Some depends on your plan) --')),
            array('value' => 'alphacube', 'label' => Mage::helper('chat')->__('Alphacube')),
            array('value' => 'plastic', 'label' => Mage::helper('chat')->__('Plastic')),
            array('value' => 'solid', 'label' => Mage::helper('chat')->__('Solid')),
            array('value' => 'floral', 'label' => Mage::helper('chat')->__('Floral')),
            array('value' => 'windows7', 'label' => Mage::helper('chat')->__('Windows 7')),
            array('value' => 'macOs', 'label' => Mage::helper('chat')->__('MacOs')),
            array('value' => 'chrome', 'label' => Mage::helper('chat')->__('Chrome')),
        );
    }
}
