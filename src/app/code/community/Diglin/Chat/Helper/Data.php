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

class Diglin_Chat_Helper_Data extends Mage_Core_Helper_Abstract
{
    const ZOPIM_BASE_URL = 'https://www.zopim.com/';

    const ZOPIM_LOGIN_URL = 'https://www.zopim.com/plugins/login';

    const ZOPIM_SIGNUP_URL = 'https://www.zopim.com/plugins/createTrialAccount';

    const ZOPIM_GETACCOUNTDETAILS_URL = 'https://www.zopim.com/plugins/getAccountDetails';

    const ZOPIM_DASHBOARD_URL = 'https://dashboard.zopim.com';

    private $_config;
    
    public function __construct ()
    {
        $this->_config = Mage::getStoreConfig('chat');
    }

    public function getCurrentPageURL()
    {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        $pageURL = preg_replace("/\?.*$/", "", $pageURL);

        return $pageURL;
    }

    public function doPostRequest($url, $_data, $useSSL)
    {
        if ($useSSL != "zopimUseSSL") {
            $url = str_replace("https", "http", $url);
        }

        $data = array();
        while(list($n,$v) = each($_data)){
            $data[] = urlencode($n)."=".urlencode($v);
        }
        $data = implode('&', $data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
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
        return Mage::getStoreConfigFlag('chat/chatconfig/allow_name');
    }
    
    public function allowEmail ()
    {
        return Mage::getStoreConfigFlag('chat/chatconfig/allow_email');
    }
    
    public function getEnabled ()
    {
        return Mage::getStoreConfigFlag('chat/chatconfig/enabled');
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
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/chatconfig/disable_sound') && !Mage::getStoreConfig('chat/widgetconfig/disable_sound')) {
            return Mage::getStoreConfig('chat/chatconfig/disable_sound');
        }
        return Mage::getStoreConfig('chat/widgetconfig/disable_sound');
    }

    /* Greetings Config */

    public function getOnlineMessage ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/chatconfig/online_greeting_short') && !Mage::getStoreConfig('chat/widgetconfig/online_message')) {
            return Mage::getStoreConfig('chat/chatconfig/online_greeting_short');
        }
        return Mage::getStoreConfig('chat/widgetconfig/online_message');
    }

    public function getOfflineMessage ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/chatconfig/offline_greeting_short') && !Mage::getStoreConfig('chat/widgetconfig/offline_message')) {
            return Mage::getStoreConfig('chat/chatconfig/offline_greeting_short');
        }
        return Mage::getStoreConfig('chat/widgetconfig/offline_message');
    }

//    public function getOfflineGreeting ()
//    {
//        // Compatibility with version < 2.0.0
//        if (Mage::getStoreConfig('chat/chatconfig/away_greeting_short') && !Mage::getStoreConfig('chat/widgetconfig/offline_greeting')) {
//            return Mage::getStoreConfig('chat/chatconfig/away_greeting_short');
//        }
//        return Mage::getStoreConfig('chat/widgetconfig/offline_greeting');
//    }

//    public function getOnlineGreetingLong ()
//    {
//        // Compatibility with version < 2.0.0
//        if (Mage::getStoreConfig('chat/chatconfig/online_greeting_long') && !Mage::getStoreConfig('chat/widgetconfig/online_greeting_long')) {
//            return Mage::getStoreConfig('chat/chatconfig/online_greeting_long');
//        }
//        return Mage::getStoreConfig('chat/widgetconfig/online_greeting_long');
//    }
//
//    public function getOfflineGreetingLong ()
//    {
//        // Compatibility with version < 2.0.0
//        if (Mage::getStoreConfig('chat/chatconfig/offline_greeting_long') && !Mage::getStoreConfig('chat/widgetconfig/offline_greeting_long')) {
//            return Mage::getStoreConfig('chat/chatconfig/offline_greeting_long');
//        }
//        return Mage::getStoreConfig('chat/widgetconfig/offline_greeting_long');
//    }
//
//    public function getAwayGreetingLong ()
//    {
//        // Compatibility with version < 2.0.0
//        if (Mage::getStoreConfig('chat/chatconfig/away_greeting_long') && !Mage::getStoreConfig('chat/widgetconfig/away_greeting_long')) {
//            return Mage::getStoreConfig('chat/chatconfig/away_greeting_long');
//        }
//        return Mage::getStoreConfig('chat/widgetconfig/away_greeting_long');
//    }

    /* Widget Config */

    /**
     * If the shop owner use the dashboard.zopim.com or Magento config
     *
     * @return mixed
     */
    public function getConfigType()
    {
        return Mage::getStoreConfig('chat/widgetconfig/type_config');
    }

    /**
     * Simple or Classic Theme
     *
     * @return mixed
     */
    public function getWindowTheme ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_theme');
    }

    /**
     * @deprecated
     *
     * @return mixed
     */
//    public function getWidgetApi ()
//    {
//        return Mage::getStoreConfig('chat/widgetconfig/widget_api');
//    }

//    public function getUnreadFlag ()
//    {
//        // Compatibility with version < 2.0.0
//        if (Mage::getStoreConfig('chat/chatconfig/unreadflag') && !Mage::getStoreConfig('chat/widgetconfig/unreadflag')) {
//            return Mage::getStoreConfigFlag('chat/chatconfig/unreadflag');
//        }
//        return Mage::getStoreConfigFlag('chat/widgetconfig/unreadflag');
//    }

    /* Bubble Config */

    public function getBubbleShow ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/show') && !Mage::getStoreConfig('chat/widgetconfig/bubble_show')) {
            return Mage::getStoreConfig('chat/bubbleconfig/show');
        }
        return Mage::getStoreConfig('chat/widgetconfig/bubble_show');
    }
    
    public function getBubbleTitle ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/title') && !Mage::getStoreConfig('chat/widgetconfig/bubble_title')) {
            return Mage::getStoreConfig('chat/bubbleconfig/title');
        }
        return Mage::getStoreConfig('chat/widgetconfig/bubble_title');
    }

    public function getBubbleText ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/text') && !Mage::getStoreConfig('chat/widgetconfig/bubble_text')) {
            return Mage::getStoreConfig('chat/bubbleconfig/text');
        }
        return Mage::getStoreConfig('chat/widgetconfig/bubble_text');
    }

    public function getBubbleColorPrimary ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_bubble_color_primary');
    }

    public function getBubbleColor ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/color') && !Mage::getStoreConfig('chat/widgetconfig/theme_bubble_color')) {
            return Mage::getStoreConfig('chat/bubbleconfig/color');
        }
        return Mage::getStoreConfig('chat/widgetconfig/theme_bubble_color');
    }
    
    /* Window Config */

    public function getWindowTitle ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_title');
    }

    /**
     * @deprecated
     * @return mixed
     */
    public function getWindowColor ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/windowconfig/color') && !Mage::getStoreConfig('chat/widgetconfig/theme_primary_color')) {
            return Mage::getStoreConfig('chat/windowconfig/color');
        }
        return $this->getThemePrimaryColor();
    }

//    public function getWindowTheme ()
//    {
//        // Compatibility with version < 2.0.0
//        if (Mage::getStoreConfig('chat/windowconfig/theme') && !Mage::getStoreConfig('chat/widgetconfig/window_theme')) {
//            return Mage::getStoreConfig('chat/windowconfig/theme');
//        }
//        return Mage::getStoreConfig('chat/widgetconfig/window_theme');
//    }

    public function getWindowSize ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_size');
    }

//    public function getWindowPosition ()
//    {
//        return Mage::getStoreConfig('chat/widgetconfig/window_position');
//    }

//    public function getWindowOffsetHorizontal ()
//    {
//        return (int) Mage::getStoreConfig('chat/widgetconfig/window_offset_horizontal');
//    }
//
//    public function getWindowOffsetVertical ()
//    {
//        return (int) Mage::getStoreConfig('chat/widgetconfig/window_offset_vertical');
//    }

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
        if (Mage::getStoreConfig('chat/buttonconfig/show') && !Mage::getStoreConfigFlag('chat/widgetconfig/button_show')) {
            return Mage::getStoreConfig('chat/buttonconfig/show');
        }
        return Mage::getStoreConfigFlag('chat/widgetconfig/button_show');
    }

    public function getButtonPosition ()
    {
        if (Mage::getStoreConfig('chat/buttonconfig/position') && !Mage::getStoreConfig('chat/widgetconfig/button_position')) {
            return Mage::getStoreConfig('chat/buttonconfig/position');
        }
        return Mage::getStoreConfig('chat/widgetconfig/button_position');
    }

    public function getButtonPositionMobile ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/button_position_mobile');
    }

//    public function getButtonHideOffline ()
//    {
//        // Compatibility with version < 2.0.0
//        if (Mage::getStoreConfig('chat/buttonconfig/hidewhenoffline') && !Mage::getStoreConfigFlag('chat/widgetconfig/button_hidewhenoffline')) {
//            return Mage::getStoreConfig('chat/buttonconfig/hidewhenoffline');
//        }
//        return Mage::getStoreConfigFlag('chat/widgetconfig/button_hidewhenoffline');
//    }

//    public function getButtonOffset ()
//    {
//        if (Mage::getStoreConfig('chat/buttonconfig/offset') && !Mage::getStoreConfig('chat/widgetconfig/button_offset_vertical')) {
//            return Mage::getStoreConfig('chat/buttonconfig/offset');
//        }
//        return $this->getButtonOffsetVertical();
//    }
//
//    public function getButtonOffsetHorizontal ()
//    {
//        return (int) Mage::getStoreConfig('chat/widgetconfig/button_offset_horizontal');
//    }
//
//    public function getButtonOffsetVertical ()
//    {
//        return (int) Mage::getStoreConfig('chat/widgetconfig/button_offset_vertical');
//    }

    /* Department Config */

    public function getDepartmentsFilter ()
    {
        return Mage::getStoreConfig('chat/departments/filter');
    }

    /* Cookie Law Config */

    public function getCookieLawComply ()
    {
        return Mage::getStoreConfigFlag('chat/widgetconfig/cookielaw_comply');
    }

    public function getCookieLawConsent ()
    {
        return Mage::getStoreConfigFlag('chat/widgetconfig/cookielaw_consent');
    }

    /* Concierge Config */

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

    /* Badge Config */

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

    public function getBadgeColorPrimary ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_badge_color_primary');
    }

    public function getBadgeColor ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_badge_color');
    }

    /* Theme Config */

    public function getThemePrimaryColor()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_primary_color');
    }
}
