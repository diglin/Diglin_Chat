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

class Diglin_Chat_Model_Config_Source_Language
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'auto', 'label' => Mage::helper('chat')->__('- Auto Detect -')),
            array('value' => 'md', 'label' => Mage::helper('chat')->__('- Magento Locale Detection -')),
            array('value' => 'ar', 'label' => Mage::helper('chat')->__("Arabic")),
            array('value' => 'bg', 'label' => Mage::helper('chat')->__("Bulgarian")),
            array('value' => 'cs', 'label' => Mage::helper('chat')->__("Czech")),
            array('value' => 'da', 'label' => Mage::helper('chat')->__("Danish")),
            array('value' => 'de', 'label' => Mage::helper('chat')->__("German")),
            array('value' => 'en', 'label' => Mage::helper('chat')->__("English")),
            array('value' => 'es', 'label' => Mage::helper('chat')->__("Spanish; Castilian")),
            array('value' => 'fa', 'label' => Mage::helper('chat')->__("Persian")),
            array('value' => 'fo', 'label' => Mage::helper('chat')->__("Faroese")),
            array('value' => 'fr', 'label' => Mage::helper('chat')->__("French")),
            array('value' => 'he', 'label' => Mage::helper('chat')->__("Hebrew")),
            array('value' => 'hr', 'label' => Mage::helper('chat')->__("Croatian")),
            array('value' => 'id', 'label' => Mage::helper('chat')->__("Indonesian")),
            array('value' => 'it', 'label' => Mage::helper('chat')->__("Italian")),
            array('value' => 'ja', 'label' => Mage::helper('chat')->__("Japanese")),
            array('value' => 'ko', 'label' => Mage::helper('chat')->__("Korean")),
            array('value' => 'ms', 'label' => Mage::helper('chat')->__("Malay")),
            array('value' => 'nb', 'label' => Mage::helper('chat')->__("Norwegian Bokmal")),
            array('value' => 'nl', 'label' => Mage::helper('chat')->__("Dutch; Flemish")),
            array('value' => 'pl', 'label' => Mage::helper('chat')->__("Polish")),
            array('value' => 'pt', 'label' => Mage::helper('chat')->__("Portuguese")),
            array('value' => 'ru', 'label' => Mage::helper('chat')->__("Russian")),
            array('value' => 'sk', 'label' => Mage::helper('chat')->__("Slovak")),
            array('value' => 'sl', 'label' => Mage::helper('chat')->__("Slovenian")),
            array('value' => 'sv', 'label' => Mage::helper('chat')->__("Swedish")),
            array('value' => 'th', 'label' => Mage::helper('chat')->__("Thai")),
            array('value' => 'tr', 'label' => Mage::helper('chat')->__("Turkish")),
            array('value' => 'ur', 'label' => Mage::helper('chat')->__("Urdu")),
            array('value' => 'vi', 'label' => Mage::helper('chat')->__("Vietnamese")),
            array('value' => 'zh_CN', 'label' => Mage::helper('chat')->__("Chinese (China)")),
        );
    }

}
