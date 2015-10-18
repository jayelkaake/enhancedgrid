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
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Sweet Tooth
 *
 * @copyright  Copyright (c) 2008-2011 Sweet Tooth (http://www.sweettoothrewards.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/**
 * Grid column block.
 *
 * @category   Sweet Tooth
 * @author      Jay El-Kaake <jay@sweettoothhq.com>
 */
class TBT_Enhancedgrid_Block_Widget_Grid_Column extends Mage_Adminhtml_Block_Widget_Grid_Column
{
    protected function _getRendererByType()
    {
        switch (strtolower($this->getType())) {
            case 'image':
                $rendererClass = 'enhancedgrid/widget_grid_column_renderer_image';
                break;
            case 'category':
                $rendererClass = 'enhancedgrid/widget_grid_column_renderer_category';
                break;
            default:
                $rendererClass = parent::_getRendererByType();
                break;
        }

        return $rendererClass;
    }

    protected function _getFilterByType()
    {
        switch (strtolower($this->getType())) {
            case 'image':
                $filterClass = 'enhancedgrid/widget_grid_column_filter_image';
                break;
            default:
                $filterClass = parent::_getFilterByType();
                break;
        }

        return $filterClass;
    }
}
