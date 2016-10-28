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
class Faonni_ReCaptcha_Model_Adminhtml_System_Config_Source_Form
{
    /**
     * Returns options for form multiselect
     *
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = array();
        /* @var $backendNode Mage_Core_Model_Config_Element */
        $actionNode = Mage::getConfig()->getNode('global/recaptcha/action');
        if ($actionNode) {
            foreach ($actionNode->children() as $action => $data) {
                $optionArray[] = array('label' => (string)$data->label, 'value' => $action);
            }
        }
        return $optionArray;
    }
}