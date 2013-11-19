<?php
/**
 * Only for Translation
 * 
 */
class Diglin_Chat_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $_config;
    
    public function __construct ()
    {
        $this->_config = Mage::getStoreConfig('chat');
    }
    
    /**
     * @param array $url
     * @return array
     */
    public function getCurlOptions ($url)
    {
        $curl = new Varien_Http_Adapter_Curl();
        $curl->setConfig(array('timeout' => 5));
        $curl->write(Zend_Http_Client::GET, $url);
        $response = $curl->read();
        if ($response === false) {
            return false;
        }
        $response = preg_split('/^\r?$/m', $response, 2);
        $response = trim($response[1]);
        $options = explode("\n", $response);
        $curl->close();
        return $options;
    }
    
    public function allowName ()
    {
        return (bool) Mage::getStoreConfig('chat/chatconfig/allow_name');
    }
    
    public function allowEmail ()
    {
        return (bool) Mage::getStoreConfig('chat/chatconfig/allow_email');
    }
    
    public function getEnabled ()
    {
        return (bool) Mage::getStoreConfig('chat/chatconfig/enabled');
    }
    
    public function getLanguage ()
    {
        return Mage::getStoreConfig('chat/chatconfig/language');
    }
    
    public function getKey ()
    {
        return Mage::getStoreConfig('chat/chatconfig/key');
    }

    public function getDisableSound()
    {
        return (bool) Mage::getStoreConfig('chat/chatconfig/disable_sound');
    }

    /* Greetings Config */

    public function getOnlineGreetingShort ()
    {
        return Mage::getStoreConfig('chat/chatconfig/online_greeting_short');
    }
    
    public function getOnlineGreetingLong ()
    {
        return Mage::getStoreConfig('chat/chatconfig/online_greeting_long');
    }
    
    public function getOfflineGreetingShort ()
    {
        return Mage::getStoreConfig('chat/chatconfig/offline_greeting_short');
    }
    
    public function getOfflineGreetingLong ()
    {
        return Mage::getStoreConfig('chat/chatconfig/offline_greeting_long');
    }
    
    public function getAwayGreetingShort ()
    {
        return Mage::getStoreConfig('chat/chatconfig/away_greeting_short');
    }
    
    public function getAwayGreetingLong ()
    {
        return Mage::getStoreConfig('chat/chatconfig/away_greeting_long');
    }

    /* Widget Config */

    public function getUnreadFlag ()
    {
        return (bool) Mage::getStoreConfig('chat/widgetconfig/unreadflag');
    }

    /**
     * Widget = 0 = API v1
     * Widget = 1 = API v2
     *
     * @return bool
     */
    public function getWidget ()
    {
        return (bool) Mage::getStoreConfig('chat/widgetconfig/widget');
    }

    /* Bubble Config */

    public function getBubbleShow ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/bubble_show');
    }
    
    public function getBubbleTitle ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/bubble_title');
    }

    public function getBubbleText ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/bubble_text');
    }

    public function getBubbleColor ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_bubble_color');
    }
    
    /* Window Config */

    public function getWindowTitle ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_title');
    }

    public function getWindowTheme ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_theme');
    }

    public function getWindowColor ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_color');
    }

    public function getWindowSize ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/window_size');
    }

    public function getWindowPosition ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/window_position');
    }

    /* Window Config - API v2 */

    public function getWindowOffsetHorizontal ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/window_offset_horizontal');
    }

    public function getWindowOffsetVertical ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/window_offset_vertical');
    }

    public function getWindowOnShow()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_onshow');
    }

    public function getWindowOnHide()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_onhide');
    }

    /* Button Config */

    public function getButtonShow ()
    {
        return (bool) Mage::getStoreConfig('chat/widgetconfig/button_show');
    }

    public function getButtonPosition ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/button_position');
    }

    public function getButtonHideOffline ()
    {
        return (bool) Mage::getStoreConfig('chat/widgetconfig/button_hidewhenoffline');
    }

    /* Button Config - API v2 */

    public function getButtonOffsetBottom ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/button_offset_bottom');
    }

    public function getButtonOffsetHorizontal ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/button_offset_horizontal');
    }

    public function getButtonOffsetVertical ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/button_offset_vertical');
    }

    public function getButtonPositionMobile ()
    {
        return (int) Mage::getStoreConfig('chat/widgetconfig/button_position_mobile');
    }

    /* Department Config */

    public function getDepartmentsFilter ()
    {
        return Mage::getStoreConfig('chat/departments/filter');
    }

    /* Cookie Law Config - API v2 */

    public function getCookieLawComply ()
    {
        return (bool) Mage::getStoreConfig('chat/widgetconfig/cookielaw_comply');
    }

    public function getCookieLawConsent ()
    {
        return (bool) Mage::getStoreConfig('chat/widgetconfig/cookielaw_consent');
    }

    /* Concierge Config - API v2 */

    public function getConciergeAvatar ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/concierge_avatar');
    }

    public function getConciergeName ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/concierge_name');
    }

    public function getConciergeTitle ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/concierge_title');
    }

    /* Badge Config - API v2 */

    public function getBadgeShow()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_show');
    }

    public function getBadgeLayout()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_layout');
    }

    public function getBadgeImage()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_image');
    }

    public function getBadgeText()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_text');
    }

    public function getBadgeColor ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_badge_color');
    }

    /* Theme Config - API v2 */

    public function getThemeThemes()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_themes');
    }

    public function getThemePrimaryColor()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_primary_color');
    }
}
