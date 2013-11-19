<?php
class Diglin_Chat_Model_Config_Source_MobilePosition
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
            array('value' => 'br', 'label' => Mage::helper('chat')->__('Bottom Right')),
        );
    }

}
