<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Carrier;

interface BaseInterface
{
    /**
     * @return \Magento\Shipping\Model\Rate\Result
     */
    public function getResult();

    /**
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    public function getRateMethod();

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateRequestInterface
     */
    public function getCalculateRequest();

    /**
     * @return float
     */
    public function getCartTotal();
}
