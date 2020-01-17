<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface BaseInterface
{
    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance();

    /**
     * @return \Mygento\Shipment\Api\PointManagerInterface
     */
    public function getPointManager();
}
