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
 * @category   WDCA
 * @package    TBT_Enhancedgrid
 * @copyright  Copyright (c) 2008-2010 WDCA (http://www.wdca.ca)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Grid checkbox column renderer
 *
 * @category   WDCA
 * @package    TBT_Enhancedgrid
 * @author      WDCA <contact@wdca.ca>
 */
class TBT_Enhancedgrid_Model_System_Config_Source_Columns_Show
{
    public function toOptionArray()
    {
    
        $collection = Mage::getResourceModel('eav/entity_attribute_collection')
            ->setEntityTypeFilter( Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId() )
            ->addFilter("is_visible", 1);
        $cols = array();
        $cols[] = array('value' => 'id',   'label' => 'ID');
        $cols[] = array('value' => 'type_id',   'label' => 'Type (simple, bundle, etc)');
        $cols[] = array('value' => 'attribute_set_id',   'label' => 'Attribute Set');
        $cols[] = array('value' => 'qty',   'label' => 'Quantity');
        $cols[] = array('value' => 'websites',   'label' => 'Websites');
        $cols[] = array('value' => 'categories',   'label' => 'Categories');
        //@nelkaake Tuesday April 27, 2010 :
        $cols[] = array('value' => 'created_at',   'label' => 'Date Created');
        foreach($collection->getItems() as $col) {
            $cols[] = array('value' => $col->getAttributeCode(),   'label' => $col->getFrontendLabel());
        }
        return $cols;
    }
}