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
        $this->setHelper(Mage::helper('chat'));
        parent::__construct();
    }

    /**
     * @deprecated
     * @param bool $value
     * @return $this;
     */
    public function forceButtonDisplay($value = false)
    {
        return $this->setForceBubbleDisplay($value);
    }

    /**
     * @deprecated
     * @param bool $value
     * @return $this;
     */
    public function forceBubbleDisplay($value = false)
    {
        return $this->setForceBubbleDisplay($value);
    }

    /**
     * Set to force the button display
     *
     * @param bool $value
     * @return $this
     */
    public function setForceButtonDisplay($value = false)
    {
        $this->_options['force_button_display'] = (bool) $value;
        return $this;
    }

    /**
     * Set to force the bubble display (only API v1 or V2 with classic theme)
     *
     * @param bool $value
     * @return $this
     */
    public function setForceBubbleDisplay($value = false)
    {
        $this->_options['force_bubble_display'] = (bool) $value;
        return $this;
    }

    /**
     * get if we force the button display or not
     *
     * @return bool
     */
    public function getForceButtonDisplay()
    {
        return (isset($this->_options['force_button_display'])) ? $this->_options['force_button_display'] : false;
    }

    /**
     * get if we force the button display or not (only API v1 or V2 with classic theme)
     *
     * @return bool
     */
    public function getForceBubbleDisplay()
    {
        return (isset($this->_options['force_bubble_display'])) ? $this->_options['force_bubble_display'] : false;
    }

    /**
     * @param \Diglin_Chat_Helper_Data $helper
     */
    public function setHelper($helper)
    {
        $this->_helper = $helper;
    }

    /**
     * @return \Diglin_Chat_Helper_Data
     */
    public function getHelper()
    {
        return $this->_helper;
    }

    /**
     * Do we use the new API or the old one?
     *
     * @return bool
     */
    public function getIsNewApi()
    {
        return (bool) $this->getHelper()->getWidget();
    }

    /**
     * Get the list of greetings options
     *
     * @return string
     */
    public function getGreetingsOptions()
    {
        $data = array();

        if (!$this->getIsNewApi()) {
            $data[] = "'online': ['".$this->getHelper()->getOnlineGreetingShort() . "', '" . $this->getHelper()->getOnlineGreetingLong() . "']";
            $data[] = "'offline': ['".$this->getHelper()->getOfflineGreetingShort() . "', '" . $this->getHelper()->getOfflineGreetingLong() . "']";
            $data[] = "'away': ['".$this->getHelper()->getAwayGreetingShort() . "', '" . $this->getHelper()->getAwayGreetingLong() . "']";
        } else {
            $data[] = "'online': '".$this->getHelper()->getOnlineGreetingLong() . "'";
            $data[] = "'offline': '".$this->getHelper()->getOfflineGreetingLong() . "'";
        }
        
        if (count($data) > 0) {
            $data = implode(',',$data);
            return "\$zopim.livechat.setGreetings({" . $data . "});";
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
        if ($this->getHelper()->getLanguage() == 'auto') {
            return null;
        }
        
        if ($this->getHelper()->getLanguage() == 'md') {
            return "\$zopim.livechat.setLanguage('" . substr(Mage::app()->getLocale()->getLocale(),0,2)."'" . "\n";
        }

        return "\$zopim.livechat.setLanguage('" . $this->getHelper()->getLanguage() . "')" . "\n";
    }

    /**
     * Get the name to display
     *
     * @return null|string
     */
    public function getName()
    {
        if ($this->getHelper()->allowName() && strlen(Mage::helper('customer')->getCurrentCustomer()->getName()) > 0) {
            return "\$zopim.livechat.setName('" . Mage::helper('customer')->getCurrentCustomer()->getName() . "');" . "\n";
        }

        return;
    }

    /**
     * Get the email to link
     *
     * @return null|string
     */
    public function getEmail()
    {
        if ($this->getHelper()->allowEmail() && strlen(Mage::helper('customer')->getCurrentCustomer()->getEmail()) > 0) {
            return  "\$zopim.livechat.setEmail('" . Mage::helper('customer')->getCurrentCustomer()->getEmail() . "');" . "\n";
        }

        return;
    }

    /**
     * Disable or not sound notification
     *
     * @return string
     */
    public function getDisableSound()
    {
        if ($this->getHelper()->getDisableSound()) {
            return "\$zopim.livechat.setDisableSound(true);" . "\n";
        } else {
            return "\$zopim.livechat.setDisableSound(false);" . "\n";
        }
    }

    /**
     * Disable or not sound notification
     *
     * @return string
     */
    public function getTheme()
    {
        if (strlen($this->getHelper()->getThemeThemes()) > 0) {
            return "\$zopim.livechat.theme.setTheme('" . $this->getHelper()->getThemeThemes() . "');" . "\n";
        }
        return;
    }

    /**
     * get the Bubble options
     *
     * @return string
     */
    public function getBubbleOptions()
    {
        $out = array();

        if ($this->getIsNewApi() && $this->getHelper()->getThemeThemes() == 'simple') {
            return;
        }

        if (strlen($this->getHelper()->getBubbleTitle()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setTitle('" . $this->getHelper()->getBubbleTitle() . "')";
        }

        if (strlen($this->getHelper()->getBubbleText()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setText('" . $this->getHelper()->getBubbleText() . "')";
        }

        if (strlen($this->getHelper()->getBubbleColor()) > 0) {
            if (!$this->getIsNewApi()) {
                $out[] = "\$zopim.livechat.bubble.setColor('" . $this->getHelper()->getBubbleColor() . "')";
            } else {
                $out[] = "\$zopim.livechat.theme.setColor('" . $this->getHelper()->getBubbleColor() . "', 'bubble')";
                $out[] = "\$zopim.livechat.theme.reload();";
            }
        }

        if ($this->getHelper()->getBubbleShow() == 'show' || $this->getForceBubbleDisplay()) {
            $out[] = "\$zopim.livechat.bubble.show()";
        } elseif ($this->getHelper()->getBubbleShow() == 'hide') {
            $out[] = "\$zopim.livechat.bubble.hide()";
        } elseif ($this->getHelper()->getBubbleShow() == 'reset') { // reset on each page reload
            $out[] = "\$zopim.livechat.bubble.reset()";
        }

        if (count($out) > 0) {
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
        $out = array();

        if ($this->getIsNewApi()) {
            if (strlen($this->getHelper()->getWindowTitle()) > 0) {
                $out[] = "\$zopim.livechat.window.setTitle('" . $this->getHelper()->getWindowTitle() . "')";
            }

            if (strlen($this->getHelper()->getWindowSize()) > 0) {
                $out[] = "\$zopim.livechat.window.setSize('" . $this->getHelper()->getWindowSize() . "')";
            }

            if (strlen($this->getHelper()->getWindowOffsetVertical()) > 0) {
                $out[] = "\$zopim.livechat.window.setOffsetVertical('" . $this->getHelper()->getWindowOffsetVertical() . "')";
            }

            if (strlen($this->getHelper()->getWindowOffsetHorizontal()) > 0) {
                $out[] = "\$zopim.livechat.window.setOffsetHorizontal('" . $this->getHelper()->getWindowOffsetHorizontal() . "')";
            }

            if (strlen($this->getHelper()->getWindowPosition()) > 0) {
                $out[] = "\$zopim.livechat.window.setPosition('" . $this->getHelper()->getWindowPosition() . "')";
            }

            if (strlen($this->getHelper()->getWindowOnShow())) {
                $out[] = "\$zopim.livechat.window.onShow('" . $this->getHelper()->getWindowOnShow() . "')";
            }

            if (strlen($this->getHelper()->getWindowOnHide())) {
                $out[] = "\$zopim.livechat.window.onHide('" . $this->getHelper()->getWindowOnHide() . "')";
            }

        } else {
            if (strlen($this->getHelper()->getWindowColor()) > 0 && !$this->getIsNewApi()) {
                $out[] = "\$zopim.livechat.window.setColor('" . $this->getHelper()->getWindowColor() . "')";
            }
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
        }

        return;
    }
    
    public function getButtonOptions()
    {
        $out = array();

        if (strlen($this->getHelper()->getButtonPosition()) > 0) {
            $out[] = "\$zopim.livechat.button.setPosition('" . $this->getHelper()->getButtonPosition() . "')";
        }

        if ($this->getHelper()->getButtonHideOffline()) {
            $out[] = "\$zopim.livechat.button.setHideWhenOffline(1)";
        }

        if ($this->getHelper()->getButtonShow() || $this->getForceButtonDisplay()) {
            $out[] = "\$zopim.livechat.button.show()";
        } else {
            $out[] = "\$zopim.livechat.button.hide()";
        }

        if ($this->getIsNewApi()) {
            if (strlen($this->getHelper()->getButtonOffsetVertical()) > 0) {
                $out[] = "\$zopim.livechat.button.setOffsetVertical('" . $this->getHelper()->getButtonOffsetVertical() . "')";
            }

            if (strlen($this->getHelper()->getButtonOffsetHorizontal()) > 0) {
                $out[] = "\$zopim.livechat.button.setOffsetHorizontal('" . $this->getHelper()->getButtonOffsetHorizontal() . "')";
            }

            if (strlen($this->getHelper()->getButtonPositionMobile()) > 0) {
                $out[] = "\$zopim.livechat.button.setPositionMobile('" . $this->getHelper()->getButtonPositionMobile() . "')";
            }
        } else {
            if ($this->getHelper()->getButtonOffset()) {
                $out[] = "\$zopim.livechat.button.setOffsetBottom(" . $this->getHelper()->getButtonOffset() . ")";
            }
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    public function getDepartmentsOptions()
    {
        $out = array();

        if ($this->getHelper()->getDepartmentsFilter()) {
            $out[] = "\$zopim.livechat.departments.filter(" . $this->getHelper()->getDepartmentsFilter() . ")";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }
    
    public function getUnreadFlagOptions()
    {
        // Not anymore available on API v2
        if ($this->getIsNewApi()) {
            return;
        }

        $out = array();

        $out[] = "\$zopim.livechat.unreadflag = " . (($this->getHelper()->getUnreadFlag())?'\'enable\'':'\'disable\'');

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    public function getCookieLawOptions ()
    {
        if (!$this->getIsNewApi()) {
            return;
        }

        $out = array();

        if ($this->getHelper()->getCookieLawComply()) {
            $out [] = "\$zopim.livechat.cookieLaw.comply()";

            if ($this->getHelper()->getCookieLawConsent()) {
                $out[] = "\$zopim.livechat.cookieLaw.setDefaultImplicitConsent()";
            }
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    public function getConciergeOptions ()
    {
        if (!$this->getIsNewApi() || $this->getHelper()->getThemeThemes() != 'simple') {
            return;
        }

        $out = array();

        if (strlen($this->getHelper()->getConciergeAvatar()) > 0) {
            $out[] = "\$zopim.livechat.concierge.setAvatar('" . Mage::getBaseUrl('media') . $this->getHelper()->getConciergeAvatar() . "')";
        }

        if (strlen($this->getHelper()->getConciergeName()) > 0) {
            $out[] = "\$zopim.livechat.concierge.setName('" . $this->getHelper()->getConciergeName() . "')";
        }

        if (strlen($this->getHelper()->getConciergeTitle()) > 0) {
            $out[] = "\$zopim.livechat.concierge.setTitle('" . $this->getHelper()->getConciergeTitle() . "')";
        }

        if (!empty($out)) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    public function getBadgeOptions()
    {
        if (!$this->getIsNewApi() || $this->getHelper()->getThemeThemes() != 'simple') {
            return;
        }
        $out = array();

        if (strlen($this->getHelper()->getBadgeColor()) > 0) {
            $out[] = "\$zopim.livechat.theme.setColor('" . $this->getHelper()->getBadgeColor() . "', 'badge')";
            $out[] = "\$zopim.livechat.theme.reload();";
        }

        if (strlen($this->getHelper()->getBadgeLayout()) > 0) {
            $out[] = "\$zopim.livechat.badge.setLayout('" . $this->getHelper()->getBadgeLayout() . "')";
        }

        if (strlen($this->getHelper()->getBadgeText()) > 0) {
            $out[] = "\$zopim.livechat.badge.setText('" . $this->getHelper()->getBadgeText() . "')";
        }

        if (strlen($this->getHelper()->getBadgeImage()) > 0) {
            $out[] = "\$zopim.livechat.badge.setImage('" . Mage::getBaseUrl('media') . $this->getHelper()->getBadgeImage() . "')";
        }

        if (!empty($out)) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    protected function _toHtml()
    {
        if ($this->getHelper()->getEnabled()) {

            $zopimOptions = '';

            if (strlen($this->getName()) > 0) {
                $zopimOptions .= $this->getName();
            }
            if (strlen($this->getEmail()) > 0) {
                $zopimOptions .= $this->getEmail();
            }
            if (strlen($this->getLanguage()) > 0) {
                $zopimOptions .= $this->getLanguage();
            }

            $zopimOptions .= $this->getDisableSound();;
            $zopimOptions .= $this->getWindowOptions();
            $zopimOptions .= $this->getButtonOptions();
            $zopimOptions .= $this->getBubbleOptions();
            $zopimOptions .= $this->getGreetingsOptions();
            $zopimOptions .= $this->getDepartmentsOptions();
            $zopimOptions .= $this->getUnreadFlagOptions();
            $zopimOptions .= $this->getCookieLawOptions();
            $zopimOptions .= $this->getConciergeOptions();
            $zopimOptions .= $this->getBadgeOptions();
            $zopimOptions .= $this->getTheme();// to be set after setColor/setColors js methods

            if ($this->getIsNewApi()) {
                $template = 'chat/zopim/widget/new.phtml';
            } else {
                $template = 'chat/zopim/widget/classic.phtml';
            }

            /* @var $block Mage_Core_Block_Template */
            $block = $this->getLayout()->createBlock(
                'core/template',
                'zopim_chat'
            );

            $block->setZopimOptions($zopimOptions);
            $block->setKey($this->getHelper()->getKey());
            $block->setTemplate($template);

            return $block->toHtml();
        }

        return;
    }
}
