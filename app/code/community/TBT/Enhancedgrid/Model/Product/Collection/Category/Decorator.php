<?php
/**
 * Sweet Tooth
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
 * @category   Sweet Tooth
 * @package    TBT_Enhancedgrid
 * @copyright  Copyright (c) 2008-2011 Sweet Tooth (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TBT_Enhancedgrid_Model_Product_Collection_Category_Decorator extends TBT_Enhancedgrid_Model_Collection_Decorator_Abstract {

    
    public function setCollection(TBT_Enhancedgrid_Model_Resource_Eav_Mysql4_Product_Collection $collection) {
        return parent::setCollection( $collection );
    }

    /**
     * Adds category data for the products collection using the currently stored collection model.
     */
    public function addCategories() {
        
        $collection = $this->getCollection();
        
        $alias_prefix = $this->_getAliasPrefix();
        
        $collection->joinField( 'category_id', 'catalog/category_product', 'category_id', 'product_id=entity_id', null, 'left' );

        $category_name_attribute_id = Mage::getModel( 'eav/entity_attribute' )->loadByCode( 'catalog_category', 'name' )->getId();
        
        //@nelkaake -m 13/11/10: Added support for tables with prefixes
        $ccev_t = Mage::getConfig()->getTablePrefix() . 'catalog_category_entity_varchar';
        
        $collection->joinField( 'categories', $ccev_t, "GROUP_CONCAT({$alias_prefix}categories.value)", 'entity_id=category_id', 
            "{$alias_prefix}categories.attribute_id={$category_name_attribute_id}", 'left' );
        
        $collection->joinField( 'category', $ccev_t, 'value', 'entity_id=category_id', 
            "{$alias_prefix}category.attribute_id={$category_name_attribute_id}", 'left' );
        
        $collection->groupByAttribute( 'entity_id' );
        
        return $this;
    
    }
    


    protected function _getAliasPrefix() {
        if(Mage::helper('enhancedgrid/version')->isBaseMageVersionAtLeast('1.6')) {
            return 'at_';
        } 
        
        return '_table_';
    }

}
