<?php
/**
 * @category   Magegeeks
 * @package    Magegeeks_TwilioSMSOTP
 * @author     Magegeeks
 * @copyright  Copyright (c) 2014-2017 Magegeeks (https://www.magegeeks.in/)
 * @license    https://www.magegeeks.in/license.html
 * @contact    magegeeks@gmail.com
 */ 
namespace Magegeeks\TwilioSMSOTP\Model\Config\Source;

class Status
{
    const DISABLE = 0;
    const ENABLE = 1;
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $_manager;

    /**
     * Construct
     *
     * @param \Magento\Framework\Module\Manager $manager
     */
    public function __construct(
        \Magento\Framework\Module\Manager $manager
    ) {
        $this->_manager = $manager;
    }
    
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = [
                    [
                        'value'=>self::DISABLE,
                        'label'=>__('disable')
                    ],
                    [
                        'value'=>self::ENABLE,
                        'label'=>__('enable')
                    ]
                ];
        return $data;
    }
}
