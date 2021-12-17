<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Client;

interface AbstractClientInterface extends BaseInterface
{
    /**
     * @param string $method
     * @param array $data
     * @param int|string $scopeCode
     */
    public function sendApiRequest(string $method, $data, $scopeCode = null);

    /**
     * Создание события
     *
     * @param string $event
     * @param array $data
     */
    public function createEvent($event, $data = []);
}
