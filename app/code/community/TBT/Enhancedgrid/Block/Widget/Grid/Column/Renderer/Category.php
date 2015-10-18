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
class TBT_Enhancedgrid_Block_Widget_Grid_Column_Renderer_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $cat_map = null;

    public function __construct()
    {
        return parent::_construct();
    }

    /**
     * Renders grid column.
     *
     * @param Varien_Object $row
     *
     * @return string
     */
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    /*
    public function renderProperty(Varien_Object $row)
    {
        $val = $row->getData($this->getColumn()->getIndex());
        $val = Mage::helper('imagebyurl')->getImageUrl($val);
        $out = parent::renderProperty(). ' onclick="showImage('.$val.')" ';
        return $out;
    }

        */
    protected function _getValue(Varien_Object $row)
    {
        if ($getter = $this->getColumn()->getGetter()) {
            $val = $row->$getter();
        }
        if (self::$cat_map == null) {
            $cat_col = Mage::getModel('catalog/category')->getCollection()->addAttributeToSelect('name');
            $cat_map = array();
            foreach ($cat_col as &$c) {
                $cat_map[$c->getId()] = $c->getName();
            }
            self::$cat_map = $cat_map;
        }
        $category_ids_str = $row->getData('category_ids');
        $category_ids = explode(',', $category_ids_str);

        $cat_names = array();
        foreach (self::$cat_map as $id => $name) {
            if (array_search($id, $category_ids) !== false) {
                $cat_names[] = $name;
            }
        }
        $cat_names_str = implode(',', $cat_names);

        return $cat_names_str;
    }
}
