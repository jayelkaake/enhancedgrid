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
/**
 * Version Helper Data
 *
 * @category   TBT
 * @package    TBT_Enhancedgrid
 * @author     WDCA Team <contact@wdca.ca>
 */
class TBT_Enhancedgrid_Helper_Version extends Mage_Core_Helper_Abstract {
	
	/**
	 * Returns true if the base version of this Magento installation
	 * is equal to the version specified or newer.
	 * @param string $version
	 * @param unknown_type $task
	 */
	public function isBaseMageVersionAtLeast($version, $task = null) {
		// convert Magento Enterprise, Professional, Community to a base version
		$mage_base_version = $this->convertVersionToCommunityVersion ( Mage::getVersion (), $task );
		
		if (version_compare ( $mage_base_version, $version, '>=' )) {
			return true;
		}
		return false;
	}

	/**
	 * True if the base version is at least the verison specified without converting version numbers to other versions of Magento.
	 *
	 * @param string $version
	 * @param unknown_type $task
	 * @return boolean
	 */
	public function isRawVerAtLeast($version) {
		// convert Magento Enterprise, Professional, Community to a base version
		$mage_base_version = Mage::getVersion ();
		
		if (version_compare ( $mage_base_version, $version, '>=' )) {
			return true;
		}
		return false;
	}
	
	/**
	 * True if the base version is at least the verison specified without checking 
	 * @param string $version
	 */
	public function isEnterpriseAtLeast($version) {
	    if(!$this->isMageEnterprise()) return false;
	    
	    return $this->isRawVerAtLeast($version);
	}
	
	/**
	 *
	 * @param string $version
	 * @param unknown_type $task
	 * @return boolean
	 */
	public function isBaseMageVersion($version, $task = null) {
		// convert Magento Enterprise, Professional, Community to a base version
		$mage_base_version = $this->convertVersionToCommunityVersion ( Mage::getVersion (), $task );
		
		if (version_compare ( $mage_base_version, $version, '=' )) {
			return true;
		}
		return false;
	}
	
	/**     * @alias isBaseMageVersion     */
	public function isMageVersion($version, $task = null) {
		return $this->isBaseMageVersion ( $version, $task );
	}
	
	/**     * @alias isBaseMageVersion     */
	public function isMage($version, $task = null) {
		return $this->isBaseMageVersion ( $version, $task );
	}
	
	/**     * @alias isBaseMageVersionAtLeast     */
	public function isMageVersionAtLeast($version, $task = null) {
		return $this->isBaseMageVersionAtLeast ( $version, $task );
	}
	
	/**
	 * True if the Magento version currently running is between the versions specified inclusive 	
	 * @nelkaake -a 16/11/10: 
	 * @param string $version
	 * @param unknown_type $task
	 * @return boolean
	 */
	public function isMageVersionBetween($version1, $version2, $task = null) {
		
		$is_between = $this->isBaseMageVersionAtLeast ( $version1, $task ) && ! $this->isBaseMageVersionAtLeast ( $version2, $task );
		$is_later_version = $this->isMageVersion ( $version2 );
		return $is_between || $is_later_version;
	}
	
	/**
	 * True if the version of Magento currently being rune is Enterprise Edition
	 */
	public function isMageEnterprise() {
	    return Mage::getConfig ()->getModuleConfig ( 'Enterprise_Enterprise' ) && Mage::getConfig ()->getModuleConfig ( 'Enterprise_AdminGws' ) && Mage::getConfig ()->getModuleConfig ( 'Enterprise_Checkout' ) && Mage::getConfig ()->getModuleConfig ( 'Enterprise_Customer' );
	}
	
	/**
	 * attempt to convert an Enterprise, Professional, Community magento version number to its compatable Community version
	 * 
	 * @param string $task fix problems where direct version numbers cant be changed to a community release without knowing the intent of the task
	 */
	public function convertVersionToCommunityVersion($version, $task = null) {
		
		/* Enterprise - 
         * 1.9 | 1.8 | 1.5
         */
		if ($this->isMageEnterprise()) {
		    if (version_compare ( $version, '1.11.0', '>=' ))
		        return '1.6.0';
			if (version_compare ( $version, '1.9.1', '>=' ))
				return '1.5.0';
			if (version_compare ( $version, '1.9.0', '>=' ))
				return '1.4.2';
			if (version_compare ( $version, '1.8.0', '>=' ))
				return '1.3.1';
			return '1.3.1';
		}
		
		/* Professional - 
         * If Entprise_Enterprise module is installed but it didn't pass Enterprise_Enterprise tests
         * then the installation must be Magento Pro edition. 
         * 1.7 | 1.8
         */
		if (Mage::getConfig ()->getModuleConfig ( 'Enterprise_Enterprise' )) {
			if (version_compare ( $version, '1.8.0', '>=' ))
				return '1.4.1';
			if (version_compare ( $version, '1.7.0', '>=' ))
				return '1.3.1';
			return '1.3.1';
		}
		
		/* Community - 
         * 1.5rc2 - December 29, 2010
         * 1.4.2 - December 8, 2010
         * 1.4.1 - June 10, 2010
         * 1.3.3.0 - (April 23, 2010) *** does this release work like to 1.4.0.1?
         * 1.4.0.1 - (February 19, 2010)
         * 1.4.0.0 - (February 12, 2010)
         * 1.3.0 - March 30, 2009 
         * 1.2.1.1 - February 23, 2009 
         * 1.1 - July 24, 2008 
         * 0.6.1316 - October 18, 2007
         */
		return $version;
	}
	
	/**
	 * start E_DEPRECATED =================================================================================
	 */
	/**
	 * @deprecated use isBaseMageVersion isntead
	 * @return boolean
	 */
	public function isMageVersion12() {
		return $this->isMageVersion ( '1.2' );
	}
	
	/**
	 * @deprecated use isBaseMageVersion isntead
	 * @return boolean
	 */
	public function isMageVersion131() {
		return $this->isMageVersion ( '1.3.1' );
	}
	
	/**
	 * @deprecated use isBaseMageVersion instead
	 * @return boolean
	 */
	public function isMageVersion14() {
		return $this->isMageVersion ( '1.4' );
	}
	
	/**
	 * @deprecated use isMageVersionAtLeast isntead
	 * @return boolean
	 */
	public function isMageVersionAtLeast14() {
		//@nelkaake Changed on Sunday August 15, 2010: 
		return $this->isBaseMageVersionAtLeast ( '1.4.0.0' );
	}

/**
 * end E_DEPRECATED =================================================================================
 */
}
