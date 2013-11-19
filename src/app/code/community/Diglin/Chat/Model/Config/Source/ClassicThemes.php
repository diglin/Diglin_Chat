<?php
class Diglin_Chat_Model_Config_Source_ClassicThemes
{
    /**
     * Options getter
     *
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
