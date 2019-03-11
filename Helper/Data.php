<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Helper;

class Data extends \Mygento\Base\Helper\Data
{
    /** @var \Magento\Checkout\Model\Session */
    protected $checkoutSession;

    /** @var string */
    protected $code = 'shipment';

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Mygento\Base\Model\LogManager $logManager
     * @param \Magento\Framework\Encryption\Encryptor $encryptor
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Mygento\Base\Model\LogManager $logManager,
        \Magento\Framework\Encryption\Encryptor $encryptor,
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct(
            $logManager,
            $encryptor,
            $context
        );
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return \Magento\Quote\Model\Quote
     */
    public function getCurrentQuote()
    {
        return $this->checkoutSession->getQuote();
    }

    /**
     * @param string $path
     * @return string
     */
    public function getConfig($path)
    {
        return parent::getConfig('carriers/' . $this->code . '/' . $path);
    }

    /**
     * @return string
     */
    protected function getDebugConfigPath(): string
    {
        return 'debug';
    }
}
