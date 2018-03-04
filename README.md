# Magento 2 Twilio Integration
The Magento 2 Twilio module allows store owners to send SMS messages,  
via the Twilio API to verify customer mobile number at the time of registration.

Admin can enabled/disabled module and uses message templates defined in the module configuration. 

## Installation
In your Magento 2 root directory run:  
`composer require magegeeks/twilio-otp-sms`  
`bin/magento setup:upgrade`

## Configuration
Module settings are found in the Magento 2 admin panel under  
Stores->Configuration->Magegeeks->Twilio OTP

## License
GNU GENERAL PUBLIC LICENSE Version 3