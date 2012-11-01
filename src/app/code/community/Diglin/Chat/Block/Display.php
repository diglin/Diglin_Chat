<?php
class Diglin_Chat_Block_Display extends Mage_Core_Block_Template
{
    /**
     * @var $_helper Diglin_Chat_Helper_Data
     */
    private $_helper;
    
    private $_options;
    
    public function __construct ()
    {
        /* @var $_helper Diglin_Chat_Helper_Data */
        $this->_helper = Mage::helper('chat');
        parent::__construct();
    }
    
    public function getGreetingsOptions()
    {
        $data = array();        
        $data[] = "'online': ['".$this->_helper->getOnlineGreetingShort() . "', '" . $this->_helper->getOnlineGreetingLong() . "']";
        $data[] = "'offline': ['".$this->_helper->getOfflineGreetingShort() . "', '" . $this->_helper->getOfflineGreetingLong() . "']";
        $data[] = "'away': ['".$this->_helper->getAwayGreetingShort() . "', '" . $this->_helper->getAwayGreetingLong() . "']";
        
        if(count($data) > 0){
            $data = implode(',',$data);
            return "\$zopim.livechat.setGreetings({".$data."});";
        }else
            return;
    }
    
    public function getLanguage()
    {
        if($this->_helper->getLanguage() == 'auto'){
            return null;
        };
        
        if($this->_helper->getLanguage() == 'md'){
            return "language: '".substr(Mage::app()->getLocale()->getLocale(),0,2)."'";
        }else{
            return "language: '".$this->_helper->getLanguage()."'";
        };
    }
    
    public function getName()
    {
        return (($this->_helper->allowName() && strlen(Mage::helper('customer')->getCurrentCustomer()->getName()) > 0)?"name: '".Mage::helper('customer')->getCurrentCustomer()->getName()."'":null);
    }

    public function getEmail()
    {
        return (($this->_helper->allowEmail() && strlen(Mage::helper('customer')->getCurrentCustomer()->getEmail()) > 0)?"email: '".Mage::helper('customer')->getCurrentCustomer()->getEmail()."'":null);
    }
    
    public function getBubbleOptions()
    {
        if(strlen($this->_helper->getBubbleTitle()) > 0){
            $out[] = "\$zopim.livechat.bubble.setTitle('" . $this->_helper->getBubbleTitle() . "')";    
        }
        
        if(strlen($this->_helper->getBubbleText()) > 0){
            $out[] = "\$zopim.livechat.bubble.setText('" . $this->_helper->getBubbleText() . "')";    
        }
        
        if($this->_helper->getBubbleShow() == 'show' || $this->getForceBubbleDisplay()){
            $out[] = "\$zopim.livechat.bubble.show()";
        }elseif($this->_helper->getBubbleShow() == 'hide'){
            $out[] = "\$zopim.livechat.bubble.hide()";
        }
        
        if(isset($out) && count($out) > 0){
            return implode(';' . "\n",$out) . ';' . "\n";
        }else
            return;
    }
    
    
    public function getWindowOptions()
    {
        if(strlen($this->_helper->getWindowColor()) > 0){
            $out[] = "\$zopim.livechat.window.setColor('" . $this->_helper->getWindowColor() . "')";
        }
        
        $out[] = "\$zopim.livechat.window.setTheme('" . $this->_helper->getWindowTheme() . "')";
        
        if(isset($out) && count($out) > 0){
            return implode(';' . "\n",$out) . ';' . "\n";
        }else
            return;
    }
    
    public function getButtonOptions()
    {
        $out[] = "\$zopim.livechat.button.setPosition('" . $this->_helper->getButtonPosition() . "')";
        
        if($this->_helper->getButtonHideOffline()){
            $out[] = "\$zopim.livechat.button.setHideWhenOffline(1)";
        }
        
        if($this->_helper->getButtonShow() || $this->getForceButtonDisplay()){
            $out[] = "\$zopim.livechat.button.show()";
        }else{
            $out[] = "\$zopim.livechat.button.hide()";
        }
        
        if($this->_helper->getButtonOffset()){
            $out[] = "\$zopim.livechat.button.setOffsetBottom(".$this->_helper->getButtonOffset().")";
        }
        
        return implode(';' . "\n", $out). ';' . "\n";
    }
    
    public function forceButtonDisplay($value = false)
    {
        $this->_options['force_button_display'] = (bool) $value;
        return;
    }

    public function forceBubbleDisplay($value = false)
    {
        $this->_options['force_bubble_display'] = (bool) $value;
        return;
    }
    
    public function getForceButtonDisplay()
    {
        return (isset($this->_options['force_button_display']))?$this->_options['force_button_display']:false;
    }

    public function getForceBubbleDisplay()
    {
        return (isset($this->_options['force_bubble_display']))?$this->_options['force_bubble_display']:false;
    }
    
    public function getDepartmentsOptions()
    {
        if( $this->_helper->getDepartmentsFilter() ) {
            $out[] = "\$zopim.livechat.departments.filter(" . $this->_helper->getDepartmentsFilter() . ")";
            return implode(';' . "\n", $out). ';' . "\n";
        }else{
            return;
        }
    }
    
    public function getUnreadFlagOptions()
    {
        $out[] = "\$zopim.livechat.unreadflag = " . (($this->_helper->getUnreadFlag())?'\'enable\'':'\'disable\'');
        return implode(';' . "\n", $out). ';' . "\n";
    }
    
    protected function _toHtml()
    {
        if($this->_helper->getEnabled()) {
            
            if(!$this->_helper->getUseNewApiCall()) {
                $output = <<<SCRIPT
<script type="text/javascript">
document.write(unescape("%3Cscript src='" + document.location.protocol + "//zopim.com/?{$this->_helper->getKey()}' charset='utf-8' type='text/javascript'%3E%3C/script%3E"));
</script>
SCRIPT;
            } else {
                $output = <<<SCRIPTONDEMAND
<!-- Start of Zopim Live Chat Script -->
<script type="text/javascript">
window.\$zopim||(function(d,s){var z=\$zopim=function(c){z._.push(c)},$=
z.s=d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o
){z.set._.push(o)};$.setAttribute('charset','utf-8');$.async=!0;z.set.
_=[];$.src=('https:'==d.location.protocol?'https://ssl':'http://cdn')+
'.zopim.com/?{$this->_helper->getKey()}';$.type='text/java'+s;z.
t=+new Date;z._=[];e.parentNode.insertBefore($,e)})(document,'script')
</script>
<!-- End of Zopim Live Chat Script -->
SCRIPTONDEMAND;
            }
            
            if(strlen($this->getName()) > 0){
                $data[] = $this->getName();
            }
            if(strlen($this->getEmail()) > 0){
                $data[] = $this->getEmail();
            }
            if(strlen($this->getLanguage()) > 0){
                $data[] = $this->getLanguage();
            }
            
            $output .= "\n";
            
            if(isset($data) && count($data) > 0)
            {
                $line = implode ( ',', $data );
                $script = "\$zopim.livechat.set({ $line });" . "\n";
            }
            
            $script .= $this->getWindowOptions();
            $script .= $this->getButtonOptions();
            $script .= $this->getBubbleOptions();
            $script .= $this->getGreetingsOptions();
            if($this->_helper->getUseNewApiCall()){
                $script .= $this->getDepartmentsOptions();
                $script .= $this->getUnreadFlagOptions();
            }
            if(strlen($script) > 0){
                if($this->_helper->getUseNewApiCall()) $script = '$zopim(function(){' . $script . '});'."\n";
                $output .= '<script type="text/javascript">' ."\n". $script . "</script>";
            }
            
            return $output;
        }else
            return;
        }
}