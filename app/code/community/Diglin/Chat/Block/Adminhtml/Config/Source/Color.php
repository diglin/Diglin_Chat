<?php
class Diglin_Chat_Block_Adminhtml_Config_Source_Color extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    /**
     * Render fieldset html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render (Varien_Data_Form_Element_Abstract $element)
    {
        $staticFolder =  Mage::getBaseDir('media') . DS . 'chat' . DS;
        $urlMedia = Mage::getBaseUrl('media') . 'chat' . DS ;
        $colorFile = $staticFolder .'colors.txt';
        $handle = fopen($colorFile, 'r');
        $colors = fread($handle, filesize($colorFile));
        fclose($handle);
        
        $colorSwatch = '<tr id="' . $element->getHtmlId() . '">';
        $colorSwatch .= '<td class="label">' . $element->getLabelHtml() . '</td>';
        $colorSwatch .= '<td style="width:625px">';
        $colorSwatch .= '<style type="text/css">.swatch {float: left;width: 15px;height:20px;} .swatch:hover {background-image:url(' . $urlMedia . 'colorselectbg.gif);cursor:pointer;}</style>';
        $colorSwatch .= '<div style=\'display:inline-block;border:11px solid #888;background:#888;color:#fee;\'>';

        $colors = explode("\n", $colors);
        $i = 0;
        foreach ($colors as $color) {
            $colorSwatch .= "<div class='swatch' style='background-color: $color;' onclick=\"document.getElementById('chat_windowconfig_color').value='$color';\">&nbsp</div>";
            if (++ $i % 40 == 0) {
                $colorSwatch .= '<br />';
            }
        }
        
        $colorSwatch .= '</div>';
        $colorSwatch .= '<br />';
        //$colorSwatch .= '<input type="text" name="groups[windowconfig][fields][color][value]" id="' . $element->getHtmlId() . '" value="'.$element->getEscapedValue().'" class="'. $element->getClass() .'" />';
        $colorSwatch .= $element->getAfterElementHtml();
        $colorSwatch .= '</td>';
        $colorSwatch .= '<td class="scope-label">[STORE VIEW]</td>';
        $colorSwatch .= '<td></td>';
        
        $colorSwatch .= '</tr>';
        
        return $colorSwatch;
    }
}