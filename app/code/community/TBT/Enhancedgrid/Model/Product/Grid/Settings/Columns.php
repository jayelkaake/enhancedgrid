<?php
/**
 * WDCA
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
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   WDCA
 * @package    TBT_Enhancedgrid
 * @copyright  Copyright (c) 2008-2011 WDCA (http://www.wdca.ca)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TBT_Enhancedgrid_Model_Product_Grid_Settings_Columns extends Varien_Object {
    
    protected $columnSettings = array();
    
    public function getStore() {
        if($this->getData('store')) return $this->getData('store');
        
        return Mage::app()->getStore();
    }
    
    public function getColumnSettingsArray() {
        $this->columnSettings = array();
        $storeSettings = Mage::getStoreConfig( 'enhancedgrid/columns/showcolumns' );
        
        $tempArr = explode( ',', $storeSettings );
        
        foreach ($tempArr as $showCol) {
            $this->columnSettings[trim( $showCol )] = true;
        }
        
        return $this->columnSettings;
    }
    
    
    public function getDefaults() {
        $truncate = Mage::getStoreConfig( 'enhancedgrid/general/truncatelongtextafter' );
        $currency = $this->getStore()->getBaseCurrency()->getCode();
        $defaults = array(
            'cost' => array(
                'type' => 'price', 
                'width' => '30px', 
                'header' => Mage::helper( 'catalog' )->__( 'Cost' ), 
                'currency_code' => $currency
            ), 
            'weight' => array(
                'type' => 'number', 
                'width' => '30px', 
                'header' => Mage::helper( 'catalog' )->__( 'Weight' )
            ), 
            'bss_weight' => array(
                'type' => 'number', 
                'width' => '30px', 
                'header' => Mage::helper( 'catalog' )->__( 'BSS Weight' )
            ), 
            'url_key' => array(
                'type' => 'text', 
                'width' => '100px', 
                'header' => Mage::helper( 'catalog' )->__( 'Url Key' )
            ), 
            'tier_price' => array(
                'type' => 'price', 
                'width' => '100px', 
                'header' => Mage::helper( 'catalog' )->__( 'Tier Price' ), 
                'currency_code' => $currency
            ), 
            'tax_class_id' => array(
                'type' => 'text', 
                'width' => '100px', 
                'header' => Mage::helper( 'catalog' )->__( 'Tax Class ID' )
            ), 
            'special_to_date' => array(
                'type' => 'date', 
                'width' => '100px', 
                'header' => Mage::helper( 'catalog' )->__( 'Spshl TO Date' )
            ), 
            //@nelkaake Tuesday April 27, 2010 :
            'created_at' => array(
                'type' => 'datetime', 
                'width' => '100px', 
                'header' => Mage::helper( 'catalog' )->__( 'Date Created' )
            ), 
            'special_price' => array(
                'type' => 'price', 
                'width' => '30px', 
                'header' => Mage::helper( 'catalog' )->__( 'Special Price' ), 
                'currency_code' => $currency
            ), 
            'special_from_date' => array(
                'type' => 'date', 
                'width' => '100px', 
                'header' => Mage::helper( 'catalog' )->__( 'Spshl FROM Date' )
            ), 
            'color' => array(
                'type' => 'text', 
                'width' => '70px', 
                'header' => Mage::helper( 'catalog' )->__( 'Color' )
            ), 
            'size' => array(
                'type' => 'text', 
                'width' => '70px', 
                'header' => Mage::helper( 'catalog' )->__( 'Size' )
            ), 
            'brand' => array(
                'type' => 'text', 
                'width' => '70px', 
                'header' => Mage::helper( 'catalog' )->__( 'Brand' )
            ), 
            'custom_design' => array(
                'type' => 'text', 
                'width' => '70px', 
                'header' => Mage::helper( 'catalog' )->__( 'Custom Design' )
            ), 
            'custom_design_from' => array(
                'type' => 'date', 
                'width' => '70px', 
                'header' => Mage::helper( 'catalog' )->__( 'Custom Design FRM' )
            ), 
            'custom_design_to' => array(
                'type' => 'date', 
                'width' => '70px', 
                'header' => Mage::helper( 'catalog' )->__( 'Custom Design TO' )
            ), 
            'default_category_id' => array(
                'type' => 'text', 
                'width' => '70px', 
                'header' => Mage::helper( 'catalog' )->__( 'Default Categry ID' )
            ), 
            'dimension' => array(
                'type' => 'text', 
                'width' => '75px', 
                'header' => Mage::helper( 'catalog' )->__( 'Dimensions' )
            ), 
            'manufacturer' => array(
                'type' => 'text', 
                'width' => '75px', 
                'header' => Mage::helper( 'catalog' )->__( 'Manufacturer' )
            ), 
            'meta_keyword' => array(
                'type' => 'text', 
                'width' => '200px', 
                'header' => Mage::helper( 'catalog' )->__( 'Meta Keywds' )
            ), 
            'meta_description' => array(
                'type' => 'text', 
                'width' => '200px', 
                'header' => Mage::helper( 'catalog' )->__( 'Meta Descr' )
            ), 
            'meta_title' => array(
                'type' => 'text', 
                'width' => '100px', 
                'header' => Mage::helper( 'catalog' )->__( 'Meta Title' )
            ), 
            'short_description' => array(
                'type' => 'text', 
                'width' => '150px', 
                'header' => Mage::helper( 'catalog' )->__( 'Short Description' ), 
                'string_limit' => $truncate
            ), 
            'description' => array(
                'type' => 'text', 
                'width' => '200px', 
                'header' => Mage::helper( 'catalog' )->__( 'Description' ), 
                'string_limit' => $truncate
            )
        );
        
        return $defaults;
    }
}