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

class Diglin_Chat_Block_Adminhtml_Config_Source_Hint
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{
    /**
     * Render fieldset html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $buttonSignUp = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label'     => $this->__('Sign Up or Login to Zopim'),
            'onclick'   => "window.open('" . $this->getUrl('chat/index/account') . "', '_self');",
            'class'     => 'add',
            'type'      => 'button',
            'id'        => 'zopim-account',
        ))
        ->toHtml();

        $buttonDashboard  = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label'     => $this->__('Zopim Dashboard'),
            'onclick'   => "window.open('". Diglin_Chat_Helper_Data::ZOPIM_DASHBOARD_URL ."', '_self');",
            'class'     => 'go',
            'type'      => 'button',
            'id'        => 'zopim-dashboard',
        ))
            ->toHtml();

        return '<p>' . $buttonSignUp . '&nbsp;' . $buttonDashboard . ' - <strong>Diglin_Chat Version: '. Mage::getConfig()->getModuleConfig('Diglin_Chat')->version .' - Powered by <a href="http://www.diglin.com/?utm_source=magento&utm_medium=extension&utm_campaign=zopim">Diglin GmbH</a></strong></p>';
    }
}
