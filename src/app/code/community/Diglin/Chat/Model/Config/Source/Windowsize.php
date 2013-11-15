<?php
class Diglin_Chat_Model_Config_Source_Windowsize
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'small', 'label'=>Mage::helper('chat')->__('Small')),
            array('value' => 'medium', 'label'=>Mage::helper('chat')->__('Medium')),
            array('value' => 'large', 'label'=>Mage::helper('chat')->__('Large')),
        );
    }

}
