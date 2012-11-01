<?php
/**
 * Only for String Translation
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
     * 
     * @param array $url
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
    
    public function getUnreadFlag ()
    {
        return (bool) Mage::getStoreConfig('chat/chatconfig/unreadflag');
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
    
    /* Bubble Config */
    public function getBubbleShow ()
    {
        return Mage::getStoreConfig('chat/bubbleconfig/show');
    }
    
    public function getBubbleTitle ()
    {
        return Mage::getStoreConfig('chat/bubbleconfig/title');
    }
    
    public function getBubbleText ()
    {
        return Mage::getStoreConfig('chat/bubbleconfig/text');
    }
    
    /* Window Config */
    public function getWindowShow ()
    {
        return Mage::getStoreConfig('chat/windowconfig/show');
    }
    
    public function getWindowColor ()
    {
        return Mage::getStoreConfig('chat/windowconfig/color');
    }
    
    public function getWindowTheme ()
    {
        return Mage::getStoreConfig('chat/windowconfig/theme');
    }
    
    /* Button Config */
    public function getButtonPosition ()
    {
        return Mage::getStoreConfig('chat/buttonconfig/position');
    }
    
    public function getButtonShow ()
    {
        return (bool) Mage::getStoreConfig('chat/buttonconfig/show');
    }
    
    public function getButtonHideOffline ()
    {
        return (bool) Mage::getStoreConfig('chat/buttonconfig/hidewhenoffline');
    }
    
    public function getButtonOffset ()
    {
        return Mage::getStoreConfig('chat/buttonconfig/offset');
    }
    
    public function getUseNewApiCall ()
    {
        return (bool) Mage::getStoreConfig('chat/chatconfig/newapicall');
    }
    
    public function getDepartmentsFilter ()
    {
        return Mage::getStoreConfig('chat/departments/filter');
    }
}