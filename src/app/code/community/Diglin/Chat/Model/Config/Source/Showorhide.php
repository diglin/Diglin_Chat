<?php
class Diglin_Chat_Model_Config_Source_Showorhide
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => '', 'label' => Mage::helper('chat')->__('Auto')),
            array('value' => 'show', 'label' => Mage::helper('chat')->__('Show')),
            array('value' => 'hide', 'label' => Mage::helper('chat')->__('Hide')),
//            array('value' => 'reset', 'label' => Mage::helper('chat')->__('reset (Only with new wigdet)')),
        );
    }
}
