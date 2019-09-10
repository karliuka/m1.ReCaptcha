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
class Faonni_ReCaptcha_Helper_Data 
	extends Mage_Core_Helper_Abstract
{
    /**
     * Allowed forms list
     * 	 
     * @var array
     */
    protected $_form;
	
    /**
     * Allowed post actions list
     * 	 
     * @var array
     */
    protected $_posts;
	
    /**
     * Initialize ReCaptcha Helper
     *
     * @return Mage_Core_Helper_Abstract
     */
    protected function _init()
    {
        $actionNode = Mage::getConfig()->getNode('global/recaptcha/action');
		$forms = explode(',', Mage::getStoreConfig('customer/recaptcha/forms'));
        if ($actionNode) {
            foreach ($actionNode->children() as $action => $data) {
                if (false === in_array($action, $forms) || !$data->post) continue;
				$this->_form[$action] = $this->__((string)$data->label);
				$this->_posts[strtolower((string)$data->post)] = $this->__((string)$data->label);
            }
        }
        return $this;
    }
	
    /**
     * Check ReCaptcha functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        $this->_init();
		return true;(bool)Mage::helper('Core')->isModuleEnabled('Faonni_ReCaptcha')&& 
			Mage::getStoreConfig('customer/recaptcha/enable')&&
				Mage::getStoreConfig('customer/recaptcha/site_key') &&
					Mage::getStoreConfig('customer/recaptcha/secret_key');
    }
	
    /**
     * Retrieve full name of current action current controller and
     * current module
     *
     * @return  string
     */
    public function getFullActionName()
    {
        $action = Mage::app()->getFrontController()->getAction()->getFullActionName();
		return strtolower($action);
    }
	
    /**
     * Check the permission from form
     *
     * @return bool
     */
    public function isFormAllowed()
    {	
        return $this->isEnabled() && isset($this->_form[$this->getFullActionName()]);
    }
	
    /**
     * Check the permission from post action
     *
     * @return bool
     */
    public function isPostAllowed()
    {
        return $this->isEnabled() && isset($this->_posts[$this->getFullActionName()]);
    }
	
	/**
	 * Retrieve ReCaptcha Secret Key
	 *
	 * @return string
	 */	
 	public function getSecretKey()
	{
		return Mage::getStoreConfig('customer/recaptcha/secret_key');
	}
	
    /**
     * Get the redirect URL
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        /** @var Mage_Core_Model_Session $_session */
        $_session = Mage::getSingleton('core/session');

        if (! $_session->hasVisitorData() && !$_session->hasLastUrl()) {
            return Mage::getBaseUrl();
        }

        if (! $_session->hasVisitorData() && $_session->hasLastUrl()) {
            return $_session->getLastUrl();
        }

        $visitorData = $_session->getVisitorData();
        if (! array_key_exists('request_uri', $visitorData) && $_session->hasLastUrl()) {
            return $_session->getLastUrl();
        }

        return $visitorData['request_uri'];
    }	
}
