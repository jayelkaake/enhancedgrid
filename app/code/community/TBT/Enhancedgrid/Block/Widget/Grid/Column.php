<?php
/**
 * Magento
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
 * @category   Mage
 * @package    TBT_MassRelater
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Grid column block
 *
 * @category   Mage
 * @package    TBT_MassRelater
 * @author      Magento Core Team <core@magentocommerce.com>
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
