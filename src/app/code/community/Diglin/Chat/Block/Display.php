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

class Diglin_Chat_Block_Display extends Mage_Core_Block_Template
{
    private $_options;

    /**
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->setCacheLifetime(86400);
    }

    /**
     * Get Cache Key Info
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            'ZOPIM_CHAT',
            $this->getNameInLayout(),
            Mage::app()->getStore()->getId(),
            Mage::helper('customer')->getCurrentCustomer()->getId()
        );
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
     * @return \Diglin_Chat_Helper_Data
     */
    public function getChatHelper()
    {
        return Mage::helper('chat');
    }

    /**
     * Get the list of greetings options
     *
     * @return string
     */
    public function getGreetingsOptions()
    {
        $offlineMessage = $this->jsQuoteEscape($this->escapeHtml($this->getChatHelper()->getOfflineMessage()));
        $onlineMessage = $this->jsQuoteEscape($this->escapeHtml($this->getChatHelper()->getOnlineMessage()));

        $data = array();
        (!empty($onlineMessage )) ? $data[] = "'online': '" . $onlineMessage  . "'" : null;
        (!empty($offlineMessage)) ? $data[] = "'offline': '" . $offlineMessage . "'" : null;

        if (count($data) > 0) {
            $data = implode(',',$data);
            return "\$zopim.livechat.setGreetings({" . $data . "});" . "\n";
        }
        return null;
    }

    /**
     * Get the language option
     *
     * @return null|string
     */
    public function getLanguage()
    {
        if ($this->getChatHelper()->getLanguage() == 'auto') {
            return null;
        }
        
        if ($this->getChatHelper()->getLanguage() == 'md') {
            return "\$zopim.livechat.setLanguage('" . substr(Mage::app()->getLocale()->getLocale(),0,2)."');" . "\n";
        }
        return "\$zopim.livechat.setLanguage('" . $this->getChatHelper()->getLanguage() . "');" . "\n";
    }

    /**
     * Get the name to display
     *
     * @return null|string
     */
    public function getName()
    {
        if ($this->getChatHelper()->allowName() && Mage::getSingleton('customer/session')->isLoggedIn()) {
            return "\$zopim.livechat.setName('" . $this->jsQuoteEscape(Mage::getSingleton('customer/session')->getCustomer()->getName()) . "');" . "\n";
        }
        return null;
    }

    /**
     * Get the email to link
     *
     * @return null|string
     */
    public function getEmail()
    {
        if ($this->getChatHelper()->allowEmail() && Mage::getSingleton('customer/session')->isLoggedIn()) {
            return  "\$zopim.livechat.setEmail('" . $this->jsQuoteEscape(Mage::getSingleton('customer/session')->getCustomer()->getEmail()) . "');" . "\n";
        }
        return null;
    }

    /**
     * Disable or not sound notification
     *
     * @return string
     */
    public function getDisableSound()
    {
        if ($this->getChatHelper()->getDisableSound()) {
            return "\$zopim.livechat.setDisableSound(true);" . "\n";
        }

        return "\$zopim.livechat.setDisableSound(false);" . "\n";
    }

    /**
     *
     *
     * @return string
     */
    public function getTheme()
    {
        $out = array();

        if (strlen($this->getChatHelper()->getWindowTheme()) > 0) {
            $out[] = "\$zopim.livechat.theme.setTheme('" . $this->getChatHelper()->getWindowTheme() . "')";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
        }

        return null;
    }

    /**
     * get the Bubble options
     *
     * @return string
     */
    public function getBubbleOptions()
    {
        $out = array();

        if ($this->getChatHelper()->getWindowTheme() == 'simple') {
            return null;
        }

        if (strlen($this->getChatHelper()->getBubbleTitle()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setTitle('" . $this->getChatHelper()->getBubbleTitle() . "')";
        }

        if (strlen($this->getChatHelper()->getBubbleText()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setText('" . $this->getChatHelper()->getBubbleText() . "')";
        }

        if ($this->getChatHelper()->getBubbleShow() == 'show' || $this->getForceBubbleDisplay()) {
            $out[] = "\$zopim.livechat.bubble.show()";
        } elseif ($this->getChatHelper()->getBubbleShow() == 'hide') {
            $out[] = "\$zopim.livechat.bubble.hide()";
        } elseif ($this->getChatHelper()->getBubbleShow() == 'reset') { // reset on each page reload
            $out[] = "\$zopim.livechat.bubble.reset()";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
        }

        return null;
    }

    /**
     * Get the options to define for the window
     *
     * @return string
     */
    public function getWindowOptions()
    {
        $out = array();

        if (strlen($this->getChatHelper()->getWindowTitle()) > 0) {
            $out[] = "\$zopim.livechat.window.setTitle('" . $this->jsQuoteEscape($this->getChatHelper()->getWindowTitle()) . "')";
        }
        if (strlen($this->getChatHelper()->getWindowSize()) > 0) {
            $out[] = "\$zopim.livechat.window.setSize('" . $this->getChatHelper()->getWindowSize() . "')";
        }

//            if (strlen($this->getChatHelper()->getWindowOffsetVertical()) > 0) {
//                $out[] = "\$zopim.livechat.window.setOffsetVertical('" . $this->getChatHelper()->getWindowOffsetVertical() . "')";
//            }
//
//            if (strlen($this->getChatHelper()->getWindowOffsetHorizontal()) > 0) {
//                $out[] = "\$zopim.livechat.window.setOffsetHorizontal('" . $this->getChatHelper()->getWindowOffsetHorizontal() . "')";
//            }
//
        if (strlen($this->getChatHelper()->getWindowOnShow())) {
            $out[] = "\$zopim.livechat.window.onShow('" . $this->getChatHelper()->getWindowOnShow() . "')";
        }

        if (strlen($this->getChatHelper()->getWindowOnHide())) {
            $out[] = "\$zopim.livechat.window.onHide('" . $this->getChatHelper()->getWindowOnHide() . "')";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
        }

        return null;
    }

    /**
     * Get the options to define the button
     *
     * @return string
     */
    public function getButtonOptions()
    {
        $out = array();

//        if ($this->getChatHelper()->getButtonShow() || $this->getForceButtonDisplay()) {
//            $out[] = "\$zopim.livechat.button.show()";
//        } else {
//            $out[] = "\$zopim.livechat.button.hide()";
//        }

        if (strlen($this->getChatHelper()->getButtonPosition()) > 0) {
            $out[] = "\$zopim.livechat.button.setPosition('" . $this->getChatHelper()->getButtonPosition() . "')";
            $out[] = "\$zopim.livechat.window.setPosition('" . $this->getChatHelper()->getButtonPosition() . "')";
        }

        if (strlen($this->getChatHelper()->getButtonPositionMobile()) > 0) {
            $out[] = "\$zopim.livechat.button.setPositionMobile('" . $this->getChatHelper()->getButtonPositionMobile() . "')";
        }

        if ($this->getChatHelper()->getButtonHideOffline()) {
            $out[] = "\$zopim.livechat.button.setHideWhenOffline(1)";
        }

//        if (($this->getChatHelper()->getWidgetApi() == 'new')) {
//            if (strlen($this->getChatHelper()->getButtonOffsetVertical()) > 0) {
//                $out[] = "\$zopim.livechat.button.setOffsetVertical('" . $this->getChatHelper()->getButtonOffsetVertical() . "')";
//            }
//
//            if (strlen($this->getChatHelper()->getButtonOffsetHorizontal()) > 0) {
//                $out[] = "\$zopim.livechat.button.setOffsetHorizontal('" . $this->getChatHelper()->getButtonOffsetHorizontal() . "')";
//            }
//        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return null;
    }

    /**
     * Get the option for the department feature
     *
     * @return string
     */
    public function getDepartmentsOptions()
    {
        $out = array();

        if ($this->getChatHelper()->getDepartmentsFilter()) {
            $departments = explode(',', $this->getChatHelper()->getDepartmentsFilter());
            $out[] = "\$zopim.livechat.departments.filter('" . $this->jsQuoteEscape(implode("','", $departments)) . "')";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return null;
    }

    /**
     * @deprecated
     * @return string
     */
//    public function getUnreadFlagOptions()
//    {
//        if ($this->getChatHelper()->getWidget() != 'classic') {
//            return null;
//        }
//
//        $out = array();
//        $out[] = "\$zopim.livechat.unreadflag = " . (($this->getChatHelper()->getUnreadFlag())?'\'enable\'':'\'disable\'');
//
//        if (count($out) > 0) {
//            return implode(';' . "\n", $out). ';' . "\n";
//        }
//        return null;
//    }

    /**
     * Get cookie law options
     *
     * @return string
     */
    public function getCookieLawOptions ()
    {
        $out = array();

        if ($this->getChatHelper()->getCookieLawComply()) {
            $out [] = "\$zopim.livechat.cookieLaw.comply()";

            if ($this->getChatHelper()->getCookieLawConsent()) {
                $out[] = "\$zopim.livechat.cookieLaw.setDefaultImplicitConsent()";
            }
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return null;
    }

    /**
     * Get concierge options
     *
     * @return string
     */
    public function getConciergeOptions ()
    {
        $out = array();

        if ($this->getChatHelper()->getWindowTheme() == 'classic') {
            return null;
        }

        if (strlen($this->getChatHelper()->getConciergeAvatar()) > 0) {
            $out[] = "\$zopim.livechat.concierge.setAvatar('" . Mage::getBaseUrl('media') . 'chat/' . $this->getChatHelper()->getConciergeAvatar() . "')";
        }

        if (strlen($this->getChatHelper()->getConciergeName()) > 0) {
            $out[] = "\$zopim.livechat.concierge.setName('" . $this->jsQuoteEscape($this->getChatHelper()->getConciergeName()) . "')";
        }

        if (strlen($this->getChatHelper()->getConciergeTitle()) > 0) {
            $out[] = "\$zopim.livechat.concierge.setTitle('" . $this->jsQuoteEscape($this->getChatHelper()->getConciergeTitle()) . "')";
        }

        if (!empty($out)) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return null;
    }

    /**
     * Get the Badge options
     *
     * @return string
     */
    public function getBadgeOptions()
    {
        if ($this->getChatHelper()->getWindowTheme() != 'simple') {
            return null;
        }
        $out = array();

        if (strlen($this->getChatHelper()->getBadgeLayout()) > 0) {
            $out[] = "\$zopim.livechat.badge.setLayout('" . $this->getChatHelper()->getBadgeLayout() . "')";
        }

        if (strlen($this->getChatHelper()->getBadgeText()) > 0) {
            $out[] = "\$zopim.livechat.badge.setText('" . $this->jsQuoteEscape($this->getChatHelper()->getBadgeText()) . "')";
        }

        if (strlen($this->getChatHelper()->getBadgeImage()) > 0) {
            $out[] = "\$zopim.livechat.badge.setImage('" . Mage::getBaseUrl('media') . 'chat/' . $this->getChatHelper()->getBadgeImage() . "')";
        }

        if (!$this->getChatHelper()->getButtonHideOffline()) {
            if ($this->getChatHelper()->getBadgeShow() == 'hide') {
                $out[] = "\$zopim.livechat.badge.hide()";
            } else {
                $out[] = "\$zopim.livechat.badge.show()";
            }
        }

        if (!empty($out)) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return null;
    }

    /**
     * Get the color options for window, bubble and the theme
     *
     * @return string
     */
    public function getColor()
    {
        $out = array();

//        if ($this->getChatHelper()->getWidgetApi() == 'new') {
        if (strlen($this->getChatHelper()->getThemePrimaryColor()) > 0) {
            $out[] = "\$zopim.livechat.theme.setColor('#" . ltrim($this->getChatHelper()->getThemePrimaryColor(), '#') . "', 'primary')";
        }

        // Specify Badge Color
        if ($this->getChatHelper()->getWindowTheme() == 'simple' && $this->getChatHelper()->getBadgeColorPrimary()) {
            switch ($this->getChatHelper()->getBadgeColorPrimary()){
                case 'badge_color_primary':
                    $color = $this->getChatHelper()->getThemePrimaryColor();
                    break;
                case 'badge_color_customized':
                default:
                    $color = $this->getChatHelper()->getBadgeColor();
                    if (empty($color)) {
                        $color = $this->getChatHelper()->getThemePrimaryColor();
                    }
                    break;

            }
            if (!empty($color)) {
                $out[] = "\$zopim.livechat.theme.setColor('#" . ltrim($color, '#') . "', 'badge')";
            }
        }

        // Specify Bubble Color
        if ($this->getChatHelper()->getWindowTheme() == 'classic' && $this->getChatHelper()->getBubbleColorPrimary()) {
            switch ($this->getChatHelper()->getBubbleColorPrimary()) {
                case 'bubble_color_primary':
                    $color = $this->getChatHelper()->getThemePrimaryColor();
                    break;
                case 'bubble_color_customized':
                default:
                    $color = $this->getChatHelper()->getBubbleColor();
                    if (empty($color)) {
                        $color = $this->getChatHelper()->getThemePrimaryColor();
                    }
                    break;
            }
            if (!empty($color)) {
                $out[] = "\$zopim.livechat.theme.setColor('#" . ltrim($color, '#') . "', 'bubble')";
            }
        }

        if (count($out) > 0) {
            $out[] = "\$zopim.livechat.theme.reload()";
        }

//        } else {
//            if (strlen($this->getChatHelper()->getThemePrimaryColor()) > 0) {
//                $out[] = "\$zopim.livechat.window.setColor('#" . ltrim($this->getChatHelper()->getThemePrimaryColor(), '#') . "')";
//            }
//
//            if (strlen($this->getChatHelper()->getBubbleColor()) > 0) {
//                $out[] = "\$zopim.livechat.bubble.setColor('#" . ltrim($this->getChatHelper()->getBubbleColor(), '#') . "')";
//            }
//        }

        if (!empty($out)) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return null;
    }

    /**
     * Generate the Zopim output
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->getChatHelper()->getEnabled()) {

            $zopimOptions = '';

            if ($this->getChatHelper()->getConfigType() == 'adv') {
                $zopimOptions .= $this->getCookieLawOptions(); // Must be in first place
                $zopimOptions .= $this->getDisableSound();
                $zopimOptions .= $this->getTheme(); // should be set after setColor/setColors js methods but works better here

                $zopimOptions .= $this->getConciergeOptions();
                $zopimOptions .= $this->getBadgeOptions();

                $zopimOptions .= $this->getWindowOptions();
                $zopimOptions .= $this->getGreetingsOptions();
                $zopimOptions .= $this->getButtonOptions();
                $zopimOptions .= $this->getBubbleOptions();
                $zopimOptions .= $this->getColor();
            }

            if (strlen($this->getName()) > 0) {
                $zopimOptions .= $this->getName();
            }
            if (strlen($this->getEmail()) > 0) {
                $zopimOptions .= $this->getEmail();
            }
            if (strlen($this->getLanguage()) > 0) {
                $zopimOptions .= $this->getLanguage();
            }

            $zopimOptions .= $this->getDepartmentsOptions();

            /* @var $block Mage_Core_Block_Template */
            $block = $this->getLayout()->createBlock(
                'core/template',
                'zopim_chat',
                array(
                    'template' => 'chat/widget.phtml',
                    'key' => $this->getChatHelper()->getKey(),
                    'zopim_options' => $zopimOptions
                )
            );

            return $block->toHtml();
        }

        return null;
    }
}
