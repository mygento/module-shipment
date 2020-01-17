<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Source;

class PointType implements \Magento\Framework\Option\ArrayInterface
{
    const PICKUP_POINT = 'pickup_point';
    const POSTOMAT = 'postomat';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::PICKUP_POINT,
                'label' => __('Pickup Point'),
            ],
            [
                'value' => self::POSTOMAT,
                'label' => __('Postomat'),
            ],
        ];
    }
}
