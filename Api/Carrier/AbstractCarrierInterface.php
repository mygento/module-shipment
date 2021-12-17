<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Carrier;

interface AbstractCarrierInterface extends \Magento\Shipping\Model\Carrier\AbstractCarrierInterface
{
    /**
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return mixed
     */
    public function convertWeight(\Magento\Quote\Model\Quote\Address\RateRequest $request);

    /**
     * @param \Mygento\Shipment\Api\Data\CalculateResultInterface $method
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    public function createRateMethod(\Mygento\Shipment\Api\Data\CalculateResultInterface $method);
}
