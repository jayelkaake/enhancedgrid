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
class TBT_Enhancedgrid_Block_Widget_Grid_Column_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $showImagesUrl = null;
    protected static $showByDefault = null;
    protected static $width = null;
    protected static $height = null;

    public function __construct()
    {
        if (self::$showImagesUrl == null) {
            self::$showImagesUrl = (int) Mage::getStoreConfig('enhancedgrid/images/showurl') === 1;
        }
        if (self::$showByDefault == null) {
            self::$showByDefault = (int) Mage::getStoreConfig('enhancedgrid/images/showbydefault') === 1;
        }
        if (self::$width == null) {
            self::$width = Mage::getStoreConfig('enhancedgrid/images/width');
        }
        if (self::$height == null) {
            self::$height = Mage::getStoreConfig('enhancedgrid/images/height');
        }
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
        $dored = false;
        if ($getter = $this->getColumn()->getGetter()) {
            $val = $row->$getter();
        }
        $val = $val2 = $row->getData($this->getColumn()->getIndex());
        $val = str_replace('no_selection', '', $val);
        $val2 = str_replace('no_selection', '', $val2);
        $url = Mage::helper('enhancedgrid')->getImageUrl($val);

        if (!Mage::helper('enhancedgrid')->getFileExists($val)) {
            $dored = true;
            $val .= '[!]';
        }
        if (strpos($val, 'placeholder/')) {
            $dored = true;
        }

        $filename = substr($val2, strrpos($val2, '/') + 1, strlen($val2) - strrpos($val2, '/') - 1);
        if (!self::$showImagesUrl) {
            $filename = '';
        }
        if ($dored) {
            $val = "<span style=\"color:red\" id=\"img\">$filename</span>";
        } else {
            $val = '<span>'.$filename.'</span>';
        }

        if (empty($val2)) {
            $out = '<center>'.$this->__('(no image)').'</center>';
        } else {
            $out = $val.'<center><a href="#" onclick="window.open(\''.$url.'\', \''.$val2.'\')"'.
            'title="'.$val2.'" '.' url="'.$url.'" id="imageurl">';
        }

        if (self::$showByDefault && !empty($val2)) {
            $out .= '<img src='.$url." width='".self::$width."' ";
            if (self::$height > self::$width) {
                $out .= "height='".self::$height."' ";
            }
            $out .= ' />';
        }
        //die( $this->helper('catalog/image')->init($_product, 'small_image')->resize(135, 135));
        $out .= '</a></center>';

        return $out;
    }
}
