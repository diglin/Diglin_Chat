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
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Diglin
 * @package     Diglin_Chat
 * @copyright   Copyright (c) 2011-2014 Diglin (http://www.diglin.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Diglin_Chat_Block_Display extends Mage_Core_Block_Template
{
    private $_options;

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
     * @param string $type
     * @return \Diglin_Chat_Helper_Data
     */
    public function getHelper($type = 'chat')
    {
        return Mage::helper($type);
    }

    /**
     * Get the list of greetings options
     *
     * @return string
     */
    public function getGreetingsOptions()
    {
        $data = array();
        $data[] = "'online': '" . $this->jsQuoteEscape($this->escapeHtml($this->getHelper()->getOnlineMessage())) . "'";
        $data[] = "'offline': '" . $this->jsQuoteEscape($this->escapeHtml($this->getHelper()->getOfflineMessage())) . "'";
        //$data[] = "'away': '" . $this->jsQuoteEscape($this->escapeHtml($this->getHelper()->getOfflineGreeting())) . "'";

        if (count($data) > 0) {
            $data = implode(',',$data);
            return "\$zopim.livechat.setGreetings({" . $data . "});" . "\n";
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
            return "\$zopim.livechat.setLanguage('" . substr(Mage::app()->getLocale()->getLocale(),0,2)."');" . "\n";
        }
        return "\$zopim.livechat.setLanguage('" . $this->getHelper()->getLanguage() . "');" . "\n";
    }

    /**
     * Get the name to display
     *
     * @return null|string
     */
    public function getName()
    {
        if ($this->getHelper()->allowName() && strlen(trim(Mage::helper('customer')->getCurrentCustomer()->getName())) > 1) {
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

        if (strlen($this->getHelper()->getWindowTheme()) > 0) {
            $out[] = "\$zopim.livechat.theme.setTheme('" . $this->getHelper()->getWindowTheme() . "')";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
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

        if ($this->getHelper()->getWindowTheme() == 'simple') {
            return;
        }

        if (strlen($this->getHelper()->getBubbleTitle()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setTitle('" . $this->getHelper()->getBubbleTitle() . "')";
        }

        if (strlen($this->getHelper()->getBubbleText()) > 0) {
            $out[] = "\$zopim.livechat.bubble.setText('" . $this->getHelper()->getBubbleText() . "')";
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

        if (strlen($this->getHelper()->getWindowTitle()) > 0) {
            $out[] = "\$zopim.livechat.window.setTitle('" . $this->getHelper()->getWindowTitle() . "')";
        }
        if (strlen($this->getHelper()->getWindowSize()) > 0) {
            $out[] = "\$zopim.livechat.window.setSize('" . $this->getHelper()->getWindowSize() . "')";
        }

//            if (strlen($this->getHelper()->getWindowOffsetVertical()) > 0) {
//                $out[] = "\$zopim.livechat.window.setOffsetVertical('" . $this->getHelper()->getWindowOffsetVertical() . "')";
//            }
//
//            if (strlen($this->getHelper()->getWindowOffsetHorizontal()) > 0) {
//                $out[] = "\$zopim.livechat.window.setOffsetHorizontal('" . $this->getHelper()->getWindowOffsetHorizontal() . "')";
//            }
//
        if (strlen($this->getHelper()->getWindowOnShow())) {
            $out[] = "\$zopim.livechat.window.onShow('" . $this->getHelper()->getWindowOnShow() . "')";
        }

        if (strlen($this->getHelper()->getWindowOnHide())) {
            $out[] = "\$zopim.livechat.window.onHide('" . $this->getHelper()->getWindowOnHide() . "')";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out) . ';' . "\n";
        }

        return;
    }

    /**
     * Get the options to define the button
     *
     * @return string
     */
    public function getButtonOptions()
    {
        $out = array();

//        if ($this->getHelper()->getButtonShow() || $this->getForceButtonDisplay()) {
//            $out[] = "\$zopim.livechat.button.show()";
//        } else {
//            $out[] = "\$zopim.livechat.button.hide()";
//        }

        if (strlen($this->getHelper()->getButtonPosition()) > 0) {
            $out[] = "\$zopim.livechat.button.setPosition('" . $this->getHelper()->getButtonPosition() . "')";
            $out[] = "\$zopim.livechat.window.setPosition('" . $this->getHelper()->getButtonPosition() . "')";
        }

        if (strlen($this->getHelper()->getButtonPositionMobile()) > 0) {
            $out[] = "\$zopim.livechat.button.setPositionMobile('" . $this->getHelper()->getButtonPositionMobile() . "')";
        }

//        if ($this->getHelper()->getButtonHideOffline()) {
//            $out[] = "\$zopim.livechat.button.setHideWhenOffline(1)";
//        }

//        if (($this->getHelper()->getWidgetApi() == 'new')) {
//            if (strlen($this->getHelper()->getButtonOffsetVertical()) > 0) {
//                $out[] = "\$zopim.livechat.button.setOffsetVertical('" . $this->getHelper()->getButtonOffsetVertical() . "')";
//            }
//
//            if (strlen($this->getHelper()->getButtonOffsetHorizontal()) > 0) {
//                $out[] = "\$zopim.livechat.button.setOffsetHorizontal('" . $this->getHelper()->getButtonOffsetHorizontal() . "')";
//            }
//        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    /**
     * Get the option for the department feature
     *
     * @return string
     */
    public function getDepartmentsOptions()
    {
        $out = array();

        if ($this->getHelper()->getDepartmentsFilter()) {
            $departments = explode(',', $this->getHelper()->getDepartmentsFilter());
            $out[] = "\$zopim.livechat.departments.filter('" . implode("','", $departments) . "')";
        }

        if (count($out) > 0) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    /**
     * @deprecated
     * @return string
     */
//    public function getUnreadFlagOptions()
//    {
//        if ($this->getHelper()->getWidget() != 'classic') {
//            return;
//        }
//
//        $out = array();
//        $out[] = "\$zopim.livechat.unreadflag = " . (($this->getHelper()->getUnreadFlag())?'\'enable\'':'\'disable\'');
//
//        if (count($out) > 0) {
//            return implode(';' . "\n", $out). ';' . "\n";
//        }
//        return;
//    }

    /**
     * Get cookie law options
     *
     * @return string
     */
    public function getCookieLawOptions ()
    {
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

    /**
     * Get concierge options
     *
     * @return string
     */
    public function getConciergeOptions ()
    {
        $out = array();

        if ($this->getHelper()->getWindowTheme() == 'classic') {
            return;
        }

        if (strlen($this->getHelper()->getConciergeAvatar()) > 0) {
            $out[] = "\$zopim.livechat.concierge.setAvatar('" . Mage::getBaseUrl('media') . 'chat/' . $this->getHelper()->getConciergeAvatar() . "')";
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

    /**
     * Get the Badge options
     *
     * @return string
     */
    public function getBadgeOptions()
    {
        if ($this->getHelper()->getWindowTheme() != 'simple') {
            return;
        }
        $out = array();

        if (strlen($this->getHelper()->getBadgeLayout()) > 0) {
            $out[] = "\$zopim.livechat.badge.setLayout('" . $this->getHelper()->getBadgeLayout() . "')";
        }

        if (strlen($this->getHelper()->getBadgeText()) > 0) {
            $out[] = "\$zopim.livechat.badge.setText('" . $this->getHelper()->getBadgeText() . "')";
        }

        if (strlen($this->getHelper()->getBadgeImage()) > 0) {
            $out[] = "\$zopim.livechat.badge.setImage('" . Mage::getBaseUrl('media') . 'chat/' . $this->getHelper()->getBadgeImage() . "')";
        }

        if ($this->getHelper()->getBadgeShow() == 'hide') {
            $out[] = "\$zopim.livechat.badge.hide()";
        } else {
            $out[] = "\$zopim.livechat.badge.show()";
        }

        if (!empty($out)) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    /**
     * Get the color options for window, bubble and the theme
     *
     * @return string
     */
    public function getColor()
    {
        $out = array();

//        if ($this->getHelper()->getWidgetApi() == 'new') {
        if (strlen($this->getHelper()->getThemePrimaryColor()) > 0) {
            $out[] = "\$zopim.livechat.theme.setColor('#" . ltrim($this->getHelper()->getThemePrimaryColor(), '#') . "', 'primary')";
        }

        // Specify Badge Color
        if ($this->getHelper()->getWindowTheme() == 'simple' && $this->getHelper()->getBadgeColorPrimary()) {
            switch ($this->getHelper()->getBadgeColorPrimary()){
                case 'badge_color_primary':
                    $color = $this->getHelper()->getThemePrimaryColor();
                    break;
                case 'badge_color_customized':
                default:
                    $color = $this->getHelper()->getBadgeColor();
                    if (empty($color)) {
                        $color = $this->getHelper()->getThemePrimaryColor();
                    }
                    break;

            }
            if (!empty($color)) {
                $out[] = "\$zopim.livechat.theme.setColor('#" . ltrim($color, '#') . "', 'badge')";
            }
        }

        // Specify Bubble Color
        if ($this->getHelper()->getWindowTheme() == 'classic' && $this->getHelper()->getBubbleColorPrimary()) {
            switch ($this->getHelper()->getBubbleColorPrimary()){
                case 'bubble_color_primary':
                    $color = $this->getHelper()->getThemePrimaryColor();
                    break;
                case 'bubble_color_customized':
                default:
                    $color = $this->getHelper()->getBubbleColor();
                    if (empty($color)) {
                        $color = $this->getHelper()->getThemePrimaryColor();
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
//            if (strlen($this->getHelper()->getThemePrimaryColor()) > 0) {
//                $out[] = "\$zopim.livechat.window.setColor('#" . ltrim($this->getHelper()->getThemePrimaryColor(), '#') . "')";
//            }
//
//            if (strlen($this->getHelper()->getBubbleColor()) > 0) {
//                $out[] = "\$zopim.livechat.bubble.setColor('#" . ltrim($this->getHelper()->getBubbleColor(), '#') . "')";
//            }
//        }

        if (!empty($out)) {
            return implode(';' . "\n", $out). ';' . "\n";
        }
        return;
    }

    /**
     * Generate the Zopim output
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->getHelper()->getEnabled()) {

            $zopimOptions = '';

            if ($this->getHelper()->getConfigType() == 'adv') {
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
                    'key' => $this->getHelper()->getKey(),
                    'zopim_options' => $zopimOptions
                )
            );

            return $block->toHtml();
        }

        return;
    }
}
