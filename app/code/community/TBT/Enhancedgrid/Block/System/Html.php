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
 * @copyright  Copyright (c) 2008-2010 WDCA (http://www.wdca.ca)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */ 


class TBT_Enhancedgrid_Block_System_Html
	extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
	protected $_dummyElement;
	protected $_fieldRenderer;
	protected $_values;

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
		
		$html = "";
        $html .= "
        	<div style=\" margin-bottom: 12px; width: 430px;\">
            Enhanced Grid v". Mage::getConfig()->getNode('modules/TBT_Enhancedgrid/version')  .". <a href='https://github.com/jayelkaake/enhancedgrid' target='_blank'>Click here for updates.</a><BR /> 
		";
		$html .= Mage::getBlockSingleton('enhancedgrid/widget_loyalty')->toHtml();
		$html .= "
            </div>
        ";
        $html .= "";//$this->_getFooterHtml($element);

        return $html;
    }

    protected function _getDummyElement()
    {
    	if (empty($this->_dummyElement)) {
    		$this->_dummyElement = new Varien_Object(array('show_in_default'=>1, 'show_in_website'=>1));
    	}
    	return $this->_dummyElement;
    }

    protected function _getFieldRenderer()
    {
    	if (empty($this->_fieldRenderer)) {
    		$this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
    	}
    	return $this->_fieldRenderer;
    }

	protected function _getFieldHtml($fieldset, $moduleName)
    {
		$configData = $this->getConfigData();
    	$path = 'advanced/modules_disable_output/'.$moduleName; //TODO: move as property of form
    	$data = isset($configData[$path]) ? $configData[$path] : array();

    	$e = $this->_getDummyElement();

		$moduleKey = substr($moduleName, strpos($moduleName,'_')+1);
		$ver = (Mage::getConfig()->getModuleConfig($moduleName)->version);

	
		if($ver){
			$field = $fieldset->addField($moduleName, 'label',
				array(
					'name'          => 'unused',
					'label'         => $moduleName,
					'value'         => $ver
				))->setRenderer($this->_getFieldRenderer());
			return $field->toHtml();
		}
		return '';
		
    }
}
