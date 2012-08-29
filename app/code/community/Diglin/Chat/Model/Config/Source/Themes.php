<?php
class Diglin_Chat_Model_Config_Source_Themes
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $filename =  Mage::getBaseDir('media') . DS . 'chat' . DS . 'themes.txt';
        $handle = fopen($filename, 'r');
        $themes = explode("\n",fread($handle, filesize($filename)));
        fclose($handle);
        
        foreach($themes as $theme){
            $out[] = array('value' => $theme, 'label'=>Mage::helper('chat')->__($theme)); 
        }
        
        return $out;
     }
}