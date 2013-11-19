<?php
class Diglin_Chat_Model_Config_Source_Widget
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label' => Mage::helper('chat')->__('Classic Widget')),
            array('value' => 1, 'label' => Mage::helper('chat')->__('New Widget')),
        );
    }
}
