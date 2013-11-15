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

    /**
     * Get the list of gretings options
     *
     * @return string
     */
    public function getGreetingsOptions()
    {
        $data = array();        
        $data[] = "'online': ['".$this->_helper->getOnlineGreetingShort() . "', '" . $this->_helper->getOnlineGreetingLong() . "']";
        $data[] = "'offline': ['".$this->_helper->getOfflineGreetingShort() . "', '" . $this->_helper->getOfflineGreetingLong() . "']";
        $data[] = "'away': ['".$this->_helper->getAwayGreetingShort() . "', '" . $this->_helper->getAwayGreetingLong() . "']";
        
        if (count($data) > 0) {
            $data = implode(',',$data);
            return "\$zopim.livechat.setGreetings({".$data."});";
        }

        return;
    }

    /**
     * Get the language option
     *
     * @return null|string
     */
    public function getLanguage()
    {
        if ($this->_helper->getLanguage() == 'auto') {
            return null;
        };
        
        if ($this->_helper->getLanguage() == 'md') {
            return "language: '".substr(Mage::app()->getLocale()->getLocale(),0,2)."'";
        }

        return "language: '".$this->_helper->getLanguage()."'";
    }

    /**
     * Get the name to display
     *
     * @return null|string
     */
    public function getName()
    {
        return (($this->_helper->allowName() && strlen(
                Mage::helper('customer')->getCurrentCustomer()->getName()
            ) > 0) ? "name: '" . Mage::helper('customer')->getCurrentCustomer()->getName() . "'" : null);
    }

    /**
     * Get the email to link
     *
     * @return null|string
     */
    public function getEmail()
    {
        return (($this->_helper->allowEmail() && strlen(
                Mage::helper('customer')->getCurrentCustomer()->getEmail()
            ) > 0) ? "email: '" . Mage::helper('customer')->getCurrentCustomer()->getEmail() . "'" : null);
    }

    /**
     * get the Bubble options
     *
     * @return string
     */
    public function getBubbleOptions()
    {
        if (strlen($this->_helper->getBubbleTitle()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setTitle('" . $this->_helper->getBubbleTitle() . "')";
        }

        if (strlen($this->_helper->getBubbleText()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setText('" . $this->_helper->getBubbleText() . "')";
        }

        if (strlen($this->_helper->getBubbleColor()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setColor('" . $this->_helper->getBubbleColor() . "')";
        }

        if ($this->_helper->getBubbleShow() == 'show' || $this->getForceBubbleDisplay()) {
            $out[] = "\$zopim.livechat.bubble.show()";
        } elseif ($this->_helper->getBubbleShow() == 'hide') {
            $out[] = "\$zopim.livechat.bubble.hide()";
        } elseif ($this->_helper->getBubbleShow() == 'reset') { // reset on each page reload
            $out[] = "\$zopim.livechat.bubble.reset()";
        }

        if (isset($out) && count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
        }

        return;
    }

    /**
     * Get the options to define for the window
     *
     * @return string
     */
    public function getWindowOptions()
    {
        if (strlen($this->_helper->getWindowShow()) > 0) {
            $out[] = "\$zopim.livechat.window.setTitle('" . $this->_helper->getWindowShow() . "')";
        }

        if (strlen($this->_helper->getWindowTitle()) > 0) {
            $out[] = "\$zopim.livechat.window.setTitle('" . $this->_helper->getWindowTitle() . "')";
        }

//        if (strlen($this->_helper->getWindowSize()) > 0) {
//            $out[] = "\$zopim.livechat.window.setSize('" . $this->_helper->getWindowSize() . "')";
//        }

        if (strlen($this->_helper->getWindowColor()) > 0) {
            $out[] = "\$zopim.livechat.window.setColor('" . $this->_helper->getWindowColor() . "')";
        }

        if (strlen($this->_helper->getWindowPosition()) > 0) {
            $out[] = "\$zopim.livechat.window.setPosition('" . $this->_helper->getWindowPosition() . "')";
        }

        if (strlen($this->_helper->getWindowOffsetVertical()) > 0) {
            $out[] = "\$zopim.livechat.window.setOffsetVertical('" . $this->_helper->getWindowOffsetVertical() . "')";
        }

        if (strlen($this->_helper->getWindowOffsetHorizontal()) > 0) {
            $out[] = "\$zopim.livechat.window.setOffsetHorizontal('" . $this->_helper->getWindowOffsetHorizontal() . "')";
        }

        $out[] = "\$zopim.livechat.window.setTheme('" . $this->_helper->getWindowTheme() . "')";

        if (isset($out) && count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
        }

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
        if ($this->_helper->getDepartmentsFilter()) {
            $out[] = "\$zopim.livechat.departments.filter(" . $this->_helper->getDepartmentsFilter() . ")";

            return implode(';' . "\n", $out) . ';' . "\n";
        } else {
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
        if ($this->_helper->getEnabled()) {

            /* @var $block Mage_Core_Block_Template */
            $block = $this->getLayout()->createBlock(
                'core/template',
                'zopim_chat',
                array(
                    'template' => 'chat/zopim/widget.phtml',
                    'key' => $this->_helper->getKey()
                )
            );

            if (strlen($this->getName()) > 0) {
                $data[] = $this->getName();
            }
            if (strlen($this->getEmail()) > 0) {
                $data[] = $this->getEmail();
            }
            if (strlen($this->getLanguage()) > 0) {
                $data[] = $this->getLanguage();
            }

            if (isset($data) && count($data) > 0) {
                $line = implode(',', $data);
                $script = "\$zopim.livechat.set({ $line });" . "\n";
            }

            $script .= $this->getWindowOptions();
            $script .= $this->getButtonOptions();
            $script .= $this->getBubbleOptions();
            $script .= $this->getGreetingsOptions();
            $script .= $this->getDepartmentsOptions();
            $script .= $this->getUnreadFlagOptions();

            if (strlen($script) > 0) {
                $script = '$zopim(function(){' . $script . '});' . "\n";
                $zopimOptions = '<script type="text/javascript">' . "\n" . $script . "</script>";
            }

            $block->setZopimOptions($zopimOptions);

            return $block->toHtml();
        }

        return;
    }
}
