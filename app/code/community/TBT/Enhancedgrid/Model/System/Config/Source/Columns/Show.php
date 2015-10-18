<?php

/**
 * Sweet Tooth.
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
 * @category   Sweet Tooth
 *
 * @copyright  Copyright (c) 2008-2010 Sweet Tooth (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Grid checkbox column renderer.
 *
 * @category   Sweet Tooth
 *
 * @author      Sweet Tooth <contact@sweettoothrewards.com>
 */
class TBT_Enhancedgrid_Model_System_Config_Source_Columns_Show
{
    public function toOptionArray()
    {
        $collection = $this->_getAttrCol();

        $cols = array();
        $cols[] = array('value' => 'id',   'label' => 'ID');
        $cols[] = array('value' => 'type_id',   'label' => 'Type (simple, bundle, etc)');
        $cols[] = array('value' => 'attribute_set_id',   'label' => 'Attribute Set');
        $cols[] = array('value' => 'qty',   'label' => 'Quantity');
        $cols[] = array('value' => 'websites',   'label' => 'Websites');
        $cols[] = array('value' => 'categories',   'label' => 'Categories');
        //@nelkaake Tuesday April 27, 2010 :
        $cols[] = array('value' => 'created_at',   'label' => 'Date Created');
        foreach ($collection->getItems() as $col) {
            $cols[] = array('value' => $col->getAttributeCode(),   'label' => $col->getFrontendLabel());
        }

        return $cols;
    }

    /**
     * @return Mage_Eav_Model_Mysql4_Entity_Attribute_Collection
     */
    protected function _getAttrCol()
    {
        if (Mage::helper('enhancedgrid/version')->isBaseMageVersionAtLeast('1.4')) {
            $collection = Mage::getResourceModel('catalog/product_attribute_collection');
        } else {
            $type_id = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();
            $collection = Mage::getResourceModel('eav/entity_attribute_collection');
            $collection->setEntityTypeFilter($type_id);
        }

        $collection->addFilter('is_visible', 1);

        return $collection;
    }
}
