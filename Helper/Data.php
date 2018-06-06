<?php

/**
 * @author Mygento Team
 * @copyright 2016-2018 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Helper;

class Data extends \Mygento\Base\Helper\Data
{
    /** @var \Magento\Checkout\Model\Session */
    protected $checkoutSession;

    /* @var string */
    protected $_code = 'shipment';

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Helper\Context $context,
        \Mygento\Base\Model\Logger\LoggerFactory $loggerFactory,
        \Mygento\Base\Model\Logger\HandlerFactory $handlerFactory,
        \Magento\Framework\Encryption\Encryptor $encryptor,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        parent::__construct(
            $context,
            $loggerFactory,
            $handlerFactory,
            $encryptor,
            $curl,
            $productRepository
        );
        $this->checkoutSession = $checkoutSession;
    }

    /**
     *
     * @return \Magento\Quote\Model\Quote
     */
    public function getCurrentQuote()
    {
        return $this->checkoutSession->getQuote();
    }

    /**
     *
     * @param type $path
     * @return type
     */
    public function getConfig($path)
    {
        return parent::getConfig('carriers/' . $this->_code . '/' . $path);
    }

    /**
     *
     * @return string
     */
    protected function getDebugConfigPath(): string
    {
        return 'debug';
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function emergency($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::EMERGENCY, $message, $context);
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function alert($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::ALERT, $message, $context);
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function critical($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::CRITICAL, $message, $context);
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function error($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::ERROR, $message, $context);
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function warning($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::WARNING, $message, $context);
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function notice($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::NOTICE, $message, $context);
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function info($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::INFO, $message, $context);
    }

    /**
     *
     * @param string $message
     * @param array $context
     */
    public function debug($message, array $context = [])
    {
        $this->log(\Psr\Log\LogLevel::DEBUG, $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->addLog($message);
    }
}
