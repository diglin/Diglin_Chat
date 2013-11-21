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

define('ZOPIM_DASHBOARD_URL', "https://dashboard.zopim.com/");

/* The only code part took from the Official Zopim Module for Magento */
class Diglin_Chat_Block_Dashboard extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        $username = Mage::getStoreConfig('chat/chatconfig/username');
           $html = '
         <div class="content-header" style="visibility: visible;">
         <table cellspacing="0">
         <tbody><tr>
         <td style="width: 50%;"><h3 class="icon-head head-categories" style="background-image: url(https://zopim.com/assets/branding/zopim.com/chatman/online.png")>Live Chat Dashboard</h3></td>
         </tr>
         </tbody></table>
         </div><p>
<div id="dashboarddiv" style="margin-top: -18px">
<iframe 
style="border-bottom:3px solid #dfdfdf" id="dashboardiframe" frameborder=0 src="'.ZOPIM_DASHBOARD_URL.'?username='.$username.'" height=700 width=100% scrolling="no"></iframe></div>
You may also <a href="'.ZOPIM_DASHBOARD_URL.'?username='.$username.'" target="_newWindow" onClick="javascript:document.getElementById(\'dashboarddiv\').innerHTML=\'\'; ">access the dashboard in a new window</a>.
<script langauge="javascript">
function GetHeight() {
        var y = 0;
        if (self.innerHeight) {
                y = self.innerHeight;
        } else if (document.documentElement && document.documentElement.clientHeight) {
                y = document.documentElement.clientHeight;
        } else if (document.body) {
                y = document.body.clientHeight;
        }
        return y;
}

function doResize() {
    document.getElementById("dashboardiframe").style.height= (GetHeight() - 220) + "px";
}

window.onresize = doResize;
doResize();

</script>
';
        return $html;
    }

}
