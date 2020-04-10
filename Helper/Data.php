<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Helper;

use Mygento\Base\Api\ProductAttributeHelperInterface;

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
     * @param string|null $scopeCode
     * @return string
     */
    public function getConfig($path, $scopeCode = null)
    {
        return parent::getConfig('carriers/' . $this->code . '/' . $path, $scopeCode);
    }

    /**
     * @param string $path
     * @param string|null $scopeCode
     * @return string
     */
    public function getDefaultConfig($path, $scopeCode = null)
    {
        $postfix = ProductAttributeHelperInterface::CONFIG_PATH_DEFAULT_SUFFIX;

        return $this->getConfig($path . $postfix, $scopeCode);
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return bool
     */
    public function isShippedBy(\Magento\Sales\Model\Order $order)
    {
        return strpos($order->getShippingMethod(), $this->getCode() . '_') !== false;
    }

    /**
     * @return string
     */
    protected function getDebugConfigPath(): string
    {
        return 'debug';
    }
}
