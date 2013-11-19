<?php
class Diglin_Chat_Model_Config_Source_ButtonPosition
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'bl', 'label' => Mage::helper('chat')->__('Bottom Left')),
            array('value' => 'bm', 'label' => Mage::helper('chat')->__('Bottom Middle (Only with new widget)')),
            array('value' => 'br', 'label' => Mage::helper('chat')->__('Bottom Right')),
            array('value' => 'tl', 'label' => Mage::helper('chat')->__('Top Left (Only with new widget)')),
            array('value' => 'tm', 'label' => Mage::helper('chat')->__('Top Middle (Only with new widget)')),
            array('value' => 'tr', 'label' => Mage::helper('chat')->__('Top Right (Only with new widget)')),
        );
    }
}
