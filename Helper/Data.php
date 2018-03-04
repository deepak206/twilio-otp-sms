<?php
/**
 * @category   Magegeeks
 * @package    Magegeeks_TwilioSMSOTP
 * @author     Magegeeks
 * @copyright  Copyright (c) 2014-2017 Magegeeks (https://www.magegeeks.in/)
 * @license    https://www.magegeeks.in/license.html
 * @contact    magegeeks@gmail.com
 */
namespace Magegeeks\TwilioSMSOTP\Helper;

use Magento\Customer\Model\Customer;

/**
 * Magegeeks TwilioSMSOTP Helper Data.
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const TWILIO_OTP_API_ENDPOINT = 'https://api.authy.com/protected/json/phones/verification/start';
    const TWILIO_OTP_VERIFY_ENDPOINT = 'https://api.authy.com/protected/json/phones/verification/check';
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    protected $_encryptor;

    /**
     * @param \Magento\Framework\App\Helper\Context      $context
     * @param \Magento\Framework\ObjectManagerInterface  $objectManager
     * @param \Magento\Customer\Model\Session            $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor
    ) {
        $this->_objectManager = $objectManager;
        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_encryptor = $encryptor;
    }

    /**
     * get Status of twilio
     * @return bool
     */
    public function getTwilioStatus()
    {
        return $this->_scopeConfig->getValue(
            'magegeeks/twilioconfiguration/status',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * get website base url
     * @return string
     */
    public function getSiteUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }
    /**
    * get API key
    * @retun string
    */
    public function getTwilioApiKey()
    {
        return $this->_scopeConfig->getValue(
            'magegeeks/twilioconfiguration/twilioapikey',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
    * Send otp sms
    * @return array
    */
    public function _sendSMS($phone_number, $country_code)
    {
        $apiKey = $this->_encryptor->decrypt($this->getTwilioApiKey());
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::TWILIO_OTP_API_ENDPOINT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "api_key=$apiKey&via=sms&phone_number=$phone_number&country_code=$country_code&local=en");
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return json_decode(curl_exec($ch), true);
    }

    /**
    * verification otp sms
    * @return array
    */
    public function _verifyOtp($phone_number, $verification_code, $country_code)
    {
        $apiKey = $this->_encryptor->decrypt($this->getTwilioApiKey());
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::TWILIO_OTP_VERIFY_ENDPOINT . "?api_key=$apiKey&verification_code=$verification_code&phone_number=$phone_number&country_code=$country_code");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return json_decode(curl_exec($ch), true);
    }
}
