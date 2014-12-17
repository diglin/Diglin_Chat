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

    /**
     * @return mixed|string
     */
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

    /**
     * @param string $url
     * @param array $_data
     * @param string $useSSL
     * @return mixed
     */
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

    /**
     * @return bool
     */
    public function allowName ()
    {
        return Mage::getStoreConfigFlag('chat/chatconfig/allow_name');
    }

    /**
     * @return bool
     */
    public function allowEmail ()
    {
        return Mage::getStoreConfigFlag('chat/chatconfig/allow_email');
    }

    /**
     * @return bool
     */
    public function getEnabled ()
    {
        return Mage::getStoreConfigFlag('chat/chatconfig/enabled');
    }

    /**
     * @return mixed
     */
    public function getLanguage ()
    {
        return Mage::getStoreConfig('chat/chatconfig/language');
    }

    /**
     * @return mixed
     */
    public function getKey ()
    {
        return Mage::getStoreConfig('chat/chatconfig/key');
    }

    /**
     * @return mixed
     */
    public function getDisableSound()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/chatconfig/disable_sound') && !Mage::getStoreConfig('chat/widgetconfig/disable_sound')) {
            return Mage::getStoreConfig('chat/chatconfig/disable_sound');
        }
        return Mage::getStoreConfig('chat/widgetconfig/disable_sound');
    }

    /* Greetings Config */

    /**
     * @return mixed
     */
    public function getOnlineMessage ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/chatconfig/online_greeting_short') && !Mage::getStoreConfig('chat/widgetconfig/online_message')) {
            return Mage::getStoreConfig('chat/chatconfig/online_greeting_short');
        }
        return Mage::getStoreConfig('chat/widgetconfig/online_message');
    }

    /**
     * @return mixed
     */
    public function getOfflineMessage ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/chatconfig/offline_greeting_short') && !Mage::getStoreConfig('chat/widgetconfig/offline_message')) {
            return Mage::getStoreConfig('chat/chatconfig/offline_greeting_short');
        }
        return Mage::getStoreConfig('chat/widgetconfig/offline_message');
    }

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

    /* Bubble Config */

    /**
     * @return mixed
     */
    public function getBubbleShow ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/show') && !Mage::getStoreConfig('chat/widgetconfig/bubble_show')) {
            return Mage::getStoreConfig('chat/bubbleconfig/show');
        }
        return Mage::getStoreConfig('chat/widgetconfig/bubble_show');
    }

    /**
     * @return mixed
     */
    public function getBubbleTitle ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/title') && !Mage::getStoreConfig('chat/widgetconfig/bubble_title')) {
            return Mage::getStoreConfig('chat/bubbleconfig/title');
        }
        return Mage::getStoreConfig('chat/widgetconfig/bubble_title');
    }

    /**
     * @return mixed
     */
    public function getBubbleText ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/text') && !Mage::getStoreConfig('chat/widgetconfig/bubble_text')) {
            return Mage::getStoreConfig('chat/bubbleconfig/text');
        }
        return Mage::getStoreConfig('chat/widgetconfig/bubble_text');
    }

    /**
     * @return mixed
     */
    public function getBubbleColorPrimary ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_bubble_color_primary');
    }

    /**
     * @return mixed
     */
    public function getBubbleColor ()
    {
        // Compatibility with version < 2.0.0
        if (Mage::getStoreConfig('chat/bubbleconfig/color') && !Mage::getStoreConfig('chat/widgetconfig/theme_bubble_color')) {
            return Mage::getStoreConfig('chat/bubbleconfig/color');
        }
        return Mage::getStoreConfig('chat/widgetconfig/theme_bubble_color');
    }
    
    /* Window Config */

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
    public function getWindowSize ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_size');
    }

    /**
     * @return mixed
     */
    public function getWindowOnShow()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_onshow');
    }

    /**
     * @return mixed
     */
    public function getWindowOnHide()
    {
        return Mage::getStoreConfig('chat/widgetconfig/window_onhide');
    }

    /* Button Config */

    /**
     * @return bool|mixed
     */
    public function getButtonShow ()
    {
        if (Mage::getStoreConfig('chat/buttonconfig/show') && !Mage::getStoreConfigFlag('chat/widgetconfig/button_show')) {
            return Mage::getStoreConfig('chat/buttonconfig/show');
        }
        return Mage::getStoreConfigFlag('chat/widgetconfig/button_show');
    }

    /**
     * @return mixed
     */
    public function getButtonPosition ()
    {
        if (Mage::getStoreConfig('chat/buttonconfig/position') && !Mage::getStoreConfig('chat/widgetconfig/button_position')) {
            return Mage::getStoreConfig('chat/buttonconfig/position');
        }
        return Mage::getStoreConfig('chat/widgetconfig/button_position');
    }

    /**
     * @return mixed
     */
    public function getButtonPositionMobile ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/button_position_mobile');
    }

    /**
     * @return mixed
     */
    public function getButtonHideOffline()
    {
        return Mage::getStoreConfig('chat/widgetconfig/button_hide_offline');
    }

    /* Department Config */

    /**
     * @return mixed
     */
    public function getDepartmentsFilter ()
    {
        return Mage::getStoreConfig('chat/departments/filter');
    }

    /* Cookie Law Config */

    /**
     * @return bool
     */
    public function getCookieLawComply ()
    {
        return Mage::getStoreConfigFlag('chat/widgetconfig/cookielaw_comply');
    }

    /**
     * @return bool
     */
    public function getCookieLawConsent ()
    {
        return Mage::getStoreConfigFlag('chat/widgetconfig/cookielaw_consent');
    }

    /* Concierge Config */

    /**
     * @return mixed
     */
    public function getConciergeAvatar ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/concierge_avatar');
    }

    /**
     * @return mixed
     */
    public function getConciergeName ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/concierge_name');
    }

    /**
     * @return mixed
     */
    public function getConciergeTitle ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/concierge_title');
    }

    /* Badge Config */

    /**
     * @return mixed
     */
    public function getBadgeShow()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_show');
    }

    /**
     * @return mixed
     */
    public function getBadgeLayout()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_layout');
    }

    /**
     * @return mixed
     */
    public function getBadgeImage()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_image');
    }

    /**
     * @return mixed
     */
    public function getBadgeText()
    {
        return Mage::getStoreConfig('chat/widgetconfig/badge_text');
    }

    /**
     * @return mixed
     */
    public function getBadgeColorPrimary ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_badge_color_primary');
    }

    /**
     * @return mixed
     */
    public function getBadgeColor ()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_badge_color');
    }

    /* Theme Config */

    /**
     * @return mixed
     */
    public function getThemePrimaryColor()
    {
        return Mage::getStoreConfig('chat/widgetconfig/theme_primary_color');
    }
}
