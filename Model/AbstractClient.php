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
     * @var \Mygento\Shipment\Model\Client
     */
    protected $baseClient;

    /**
     * @param \Mygento\Shipment\Model\Client $client
     */
    public function __construct(
        \Mygento\Shipment\Model\Client $client
    ) {
        $this->baseClient = $client;
    }

    /**
     * @param array $options
     * @return \Magento\Framework\HTTP\Client\Curl
     */
    public function getHttpClient(array $options = [])
    {
        return $this->baseClient->getHttpClient($options);
    }
}
