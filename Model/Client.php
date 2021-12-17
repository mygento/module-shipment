<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;

class Client implements \Mygento\Shipment\Api\Client\BaseInterface
{
    /**
     * @var \Magento\Framework\Event\Manager
     */
    private $eventManager;

    /**
     * @var CurlFactory
     */
    private $curl;

    /**
     * @param \Magento\Framework\Event\Manager $eventManager
     * @param \Magento\Framework\HTTP\Client\CurlFactory $curl
     */
    public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
        CurlFactory $curl
    ) {
        $this->curl = $curl;
        $this->eventManager = $eventManager;
    }

    /**
     * @param array $options
     * @return \Magento\Framework\HTTP\Client\Curl
     */
    public function getHttpClient(array $options = []): Curl
    {
        $curl = $this->curl->create();
        $curl->setOptions($options);

        return $curl;
    }

    /**
     * @return \Magento\Framework\Event\Manager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
