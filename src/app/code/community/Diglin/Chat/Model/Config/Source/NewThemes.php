<?php
class Diglin_Chat_Model_Config_Source_NewThemes
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'simple', 'label' => Mage::helper('chat')->__('Simple')),
            array('value' => 'dark', 'label' => Mage::helper('chat')->__('Classic')),
        );
    }
}
