<?php

/**
 * @author Mygento Team
 * @copyright 2016-2018 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

class ExtRate
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param mixed $result
     */
    public function afterImportShippingRate(
        \Magento\Quote\Model\Quote\Address\Rate $subject,
        $result,
        \Magento\Quote\Model\Quote\Address\RateResult\AbstractResult $rate
    ) {
        $result->setEstimate($rate->getEstimate());
        $result->setEstimateDates($rate->getEstimateDates());
        $result->setLatitude($rate->getLatitude());
        $result->setLongitude($rate->getLongitude());

        return $result;
    }
}
