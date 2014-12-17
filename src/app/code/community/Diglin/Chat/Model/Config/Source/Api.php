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

class Diglin_Chat_Model_Config_Source_Api
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
            array('value' => 'old', 'label' => Mage::helper('chat')->__('Old Widget')),
            array('value' => 'new', 'label' => Mage::helper('chat')->__('New Widget (2013)')),
        );
    }
}
