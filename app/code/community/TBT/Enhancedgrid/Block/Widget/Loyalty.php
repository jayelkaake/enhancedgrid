<?php

/**
 * This class passes information about current version of Enhancedgrid being run to the Sweet Tooth server.
 * All information is confidential and never distributed to any third priorities.
 *
 * @category   TBT
 *
 * @author     Sweet Tooth Team <contact@sweettoothrewards.com>
 */
class TBT_Enhancedgrid_Block_Widget_Loyalty extends Mage_Adminhtml_Block_Template
{
    public function _toHtml()
    {
        $html = <<<FEED
	    	<!-- Visit http://www.sweettoothrewards.com/m for information about this frame.  You can remove it if you want. -->
        	<iframe src="{$this->_getLoyaltyUrl()}" marginwidth="0" marginheight="0"
                	align="middle" frameborder="0"
                    scrolling="no" style="width: 500px; float: left; height: 22px;">
            </iframe>
FEED;

        return $html;
    }

    protected function _getLoyaltyUrl()
    {
        $url = $this->_getBaseLoyaltyUrl();

        $url_data = array();
        $url_data['a'] = 'enhancedgrid';
        $url_data['v'] = (string) Mage::getConfig()->getNode('modules/TBT_Enhancedgrid/version');
        $url_data['m'] =  Mage::getVersion();
        $url_data['p'] =  urlencode($this->getBaseUrl());
        $url_data['ap'] =  urlencode($this->getAction()->getFullActionName());
        //$url_data["license"] =  Mage::helper('rewards/loyalty_checker')->getLicenseKey();

        $url_data_json = json_encode($url_data);

        $salt = 'welovewdca12345!!';

        $url_data_json_hex = bin2hex($url_data_json.$salt);

        $url = $url.'?data='.$url_data_json_hex;

        return $url;
    }

    protected function _getBaseLoyaltyUrl()
    {
        $url = 'https://www.sweettoothrewards.com/m/';

        //@nelkaake: If the page is supposed to be HTTPS and the AJAX call is not HTTPS, add HTTPS
        // if it's HTTP and the url returned HTTPS, remove HTTPS
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && strpos(strtolower($url), 'https') !== 0) {
            $url = str_replace('http', 'https', $url);
        } elseif (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS'] && strpos(strtolower($url), 'https') === 0) {
            $url = str_replace('https', 'http', $url);
        } else {
            // the url is fine and we can continue because it's using the correct encryption
        }

        return $url;
    }
}
