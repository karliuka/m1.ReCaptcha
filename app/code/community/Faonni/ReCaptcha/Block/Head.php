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
class Faonni_ReCaptcha_Block_Head
	extends Mage_Core_Block_Text
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
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
		if ($this->help()->isEnabled() && $this->help()->isFormAllowed()){
			return parent::_toHtml();
		}
        return '';
    }
	
    /**
     * Before rendering html, but after trying to load cache
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        $code = Mage::app()->getLocale()->getLocaleCode();
		$this->setText("<script src='//www.google.com/recaptcha/api.js?hl=" . $code . "' async defer></script>");
		
		return parent::_beforeToHtml();
    }
}