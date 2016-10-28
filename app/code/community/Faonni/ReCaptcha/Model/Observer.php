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
class Faonni_ReCaptcha_Model_Observer
{
    /**
     * Dispatch event before action
     *
     * @param   Varien_Event_Observer $observer
     * @return  Faonni_Compare_Model_Observer
     */
    public function predispatch(Varien_Event_Observer $observer)
    {
		$helper = Mage::helper('faonni_recaptcha');
		if($helper->isPostAllowed()){
			$captcha = Mage::app()->getRequest()->getPost('g-recaptcha-response');
			
			if (!empty($captcha)){
				$client = $this->getClient('https://www.google.com/recaptcha/api/siteverify');
				$client->setParameterPost(array(
					'secret'   => $helper->getSecretKey(),
					'response' => $captcha,
					'remoteip' => Mage::helper('core/http')->getRemoteAddr(false),
				));
				
				$response = $client->request(Zend_Http_Client::POST);
				if($response->isSuccessful()){
					$json = json_decode($response->getBody());
					if(!empty($json->success) && true == $json->success){
						return $this;
					}		
				}
			}					
			Mage::getSingleton('core/session')->addError(
				$helper->__('There was an error with the recaptcha code, please try again.')
			);

			$controller = $observer->getEvent()->getControllerAction();	
			$controller->getResponse()->setRedirect($helper->getRedirectUrl())->sendResponse();
			$controller->getRequest()->setDispatched(true);
			$controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);			
		}
		return $this;
    }
	
    /**
     * Returns the Zend Http Client
	 *
     * @param string $url	 
     * @return Zend_Http_Client
     */
    public function getClient($url) 
	{
		return new Zend_Http_Client($url, array(
			'adapter'     => 'Zend_Http_Client_Adapter_Curl',
			'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false),
		));
    }	
}