<?php
class Diglin_Chat_Model_Config_Source_Layout
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'image_right', 'label' => Mage::helper('chat')->__('Image Right')),
            array('value' => 'image_left', 'label' => Mage::helper('chat')->__('Image Left')),
            array('value' => 'image_only', 'label' => Mage::helper('chat')->__('Image Only')),
            array('value' => 'text_only', 'label' => Mage::helper('chat')->__('Text Only')),
        );
    }
}
