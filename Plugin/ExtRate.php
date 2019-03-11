<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

class ExtRate
{
    /**
     * @param \Magento\Quote\Model\Quote\Address\Rate $subject
     * @param mixed $result
     * @param \Magento\Quote\Model\Quote\Address\RateResult\AbstractResult $rate
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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
