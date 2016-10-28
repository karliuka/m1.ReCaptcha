<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_ReCaptcha
 * @copyright   Copyright (c) 2015 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Faonni_ReCaptcha_Block_Form 
	extends Mage_Core_Block_Template
{
    /**
     * Retrieve ReCaptcha helper object
     *
     * @return Mage_Core_Helper_Abstract
     */
    public function help()
    {
        return Mage::helper('faonni_recaptcha');
    }
	
	/**
	 * Retrieve ReCaptcha Site Key
	 *
	 * @return string
	 */	
 	public function getSiteKey()
	{
		return Mage::getStoreConfig('customer/recaptcha/site_key');
	}
	
	/**
	 * Retrieve ReCaptcha Type
	 *
	 * @return string
	 */	
 	public function getTypes()
	{
		return Mage::getStoreConfig('customer/recaptcha/type');
	}
	
	/**
	 * Retrieve ReCaptcha Size
	 *
	 * @return string
	 */	
 	public function getSize()
	{
		return Mage::getStoreConfig('customer/recaptcha/size');
	}
	
	/**
	 * Retrieve ReCaptcha Theme
	 *
	 * @return string
	 */	
 	public function getTheme()
	{
		return Mage::getStoreConfig('customer/recaptcha/theme');
	}
	
	/**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
		$alloved = $this->help()->isFormAllowed();
		if ($alloved){
			return parent::_toHtml();
		}
        return '';
    }
}