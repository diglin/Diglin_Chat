<?php
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
        $version = Mage::getConfig()->getModuleConfig('Diglin_Chat')->version;
        return '<p><a href="javascript:window.open(\'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y66QHLU5VX5BC\')"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" alt="Donate via Paypal" /> </a>Please, Invite me for a drink for the hard work done. Thank you in advance for your donation</p>
        <p><strong>Diglin_Chat Version: '.$version.'</strong></p>';
    }
}
