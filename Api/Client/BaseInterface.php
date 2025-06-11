<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Client;

interface BaseInterface
{
    /**
     * @param array $options
     * @return \Magento\Framework\HTTP\Client\Curl
     */
    public function getHttpClient(array $options = []);

    /**
     * @return \Magento\Framework\Event\Manager
     */
    public function getEventManager();
}
