<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

class Client implements \Mygento\Shipment\Api\Client\BaseInterface
{
    /**
     * @var \Magento\Framework\Event\Manager
     */
    private $eventManager;

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    private $curl;

    /**
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     * @param \Magento\Framework\Event\Manager $eventManager
     */
    public function __construct(
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Event\Manager $eventManager
    ) {
        $this->curl = $curl;
        $this->eventManager = $eventManager;
    }

    /**
     * @param array $options
     * @return \Magento\Framework\HTTP\Client\Curl
     */
    public function getHttpClient(array $options = [])
    {
        $this->curl->setOptions($options);

        return $this->curl;
    }

    /**
     * @return \Magento\Framework\Event\Manager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
