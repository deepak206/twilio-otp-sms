<?php
/**
 * @category   Magegeeks
 * @package    Magegeeks_TwilioSMSOTP
 * @author     Magegeeks
 * @copyright  Copyright (c) 2014-2017 Magegeeks (https://www.magegeeks.in/)
 * @license    https://www.magegeeks.in/license.html
 * @contact    magegeeks@gmail.com
 */ 
namespace Magegeeks\TwilioSMSOTP\Controller\Send;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $_resultJsonFactory;
    /**
    * @var Customer register mobile number
    */
    protected $_registerNumber;
    /**
     * @var \Magegeeks\TwilioSMSOTP\Helper\Data
     */
    protected $_helper;
	/**
     * @var phone country code
     */
    protected $_countryCode;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magegeeks\TwilioSMSOTP\Helper\Data $helper
    )
    {

        parent::__construct($context);
        $this->_resultJsonFactory = $resultJsonFactory;  
        $this->_helper = $helper;
    }
    
    public function execute()
    {
        $resultJson = $this->_resultJsonFactory->create();
        if ($this->getRequest()->getPost()) {
            $messageData = $this->getRequest()->getPost();
            $this->_registerNumber = $messageData['phone_number'];
            $this->_countryCode = $messageData['country'];
            if ($messageData['request'] == 'generate') {
	            $result = $this->_helper->_sendSMS($this->_registerNumber, $this->_countryCode);
            } else {
                $result = $this->_helper->_verifyOtp($this->_registerNumber, $messageData['otp'], $this->_countryCode);
            }
        } else {
        	$result = [
            	'status' => false,
            	'message' => __("Required data is missing.")
            ];
        }
        $resultJson->setData($result);
        return $resultJson;
    }
}
