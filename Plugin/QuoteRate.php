<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

class QuoteRate
{
    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    private $serializer;

    /**
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     */
    public function __construct(\Magento\Framework\Serialize\SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\Rate $subject
     */
    public function beforeBeforeSave(\Magento\Quote\Model\Quote\Address\Rate $subject)
    {
        if ($subject->getEstimateDate()) {
            $subject->setEstimateDate($this->serializer->serialize($subject->getEstimateDate()));
        }
        if ($subject->getEstimateTime()) {
            $subject->setEstimateTime($this->serializer->serialize($subject->getEstimateTime()));
        }
    }

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
        $result->setEstimateDate($rate->getEstimateDate());
        $result->setEstimateTime($rate->getEstimateTime());
        $result->setEstimate($rate->getEstimate());

        $result->setPickupPoints($rate->getPickupPoints());
        $result->setDescription($rate->getDescription());

        // deprecated
        $result->setLatitude($rate->getLatitude());
        $result->setLongitude($rate->getLongitude());

        return $result;
    }
}
