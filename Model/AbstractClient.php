<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

abstract class AbstractClient implements \Mygento\Shipment\Api\Client\AbstractClientInterface
{
    /**
     * @var \Mygento\Shipment\Helper\Data
     */
    protected $helper;

    /**
     * @var \Mygento\Shipment\Model\Client
     */
    protected $baseClient;

    /**
     * @param \Mygento\Shipment\Model\Client $client
     */
    public function __construct(
        \Mygento\Shipment\Helper\Data $helper,
        \Mygento\Shipment\Model\Client $client
    ) {
        $this->baseClient = $client;
        $this->helper = $helper;
    }

    /**
     * @param array $options
     * @return \Magento\Framework\HTTP\Client\Curl
     */
    public function getHttpClient(array $options = [])
    {
        return $this->baseClient->getHttpClient($options);
    }

    /**
     * @return \Magento\Framework\Event\Manager
     */
    public function getEventManager()
    {
        return $this->baseClient->getEventManager();
    }

    /**
     * Создание события
     *
     * @param string $event
     * @param array $data
     */
    public function createEvent($event, $data = [])
    {
        $prefix = $this->helper->getCode() . '_';
        $this->getEventManager()->dispatch($prefix . $event, $data);
    }
}
