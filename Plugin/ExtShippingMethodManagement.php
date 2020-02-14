<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

class ExtShippingMethodManagement
{
    /**
     * @var \Magento\Quote\Api\Data\ShippingMethodExtensionFactory
     */
    private $shippingExtAttr;

    /**
     * @param \Magento\Quote\Api\Data\ShippingMethodExtensionFactory $shippingExtAttr
     */
    public function __construct(
        \Magento\Quote\Api\Data\ShippingMethodExtensionFactory $shippingExtAttr
    ) {
        $this->shippingExtAttr = $shippingExtAttr;
    }

    /**
     * @param \Magento\Quote\Model\Cart\ShippingMethodConverter $subject
     * @param mixed $result
     * @param \Magento\Quote\Model\Quote\Address\Rate $rateModel
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterModelToDataObject(
        \Magento\Quote\Model\Cart\ShippingMethodConverter $subject,
        $result,
        \Magento\Quote\Model\Quote\Address\Rate $rateModel
    ) {
        $extensionAttributes =
            $result->getExtensionAttributes()
            ?? $this->shippingExtAttr->create();

        $extensionAttributes->setEstimateDate($rateModel->getEstimateDate());
        $extensionAttributes->setEstimateTime($rateModel->getEstimateTime());
        $extensionAttributes->setEstimate($rateModel->getEstimate());

        $extensionAttributes->setPickupPoints($rateModel->getPickupPoints());
        // deprecated
        $extensionAttributes->setLatitude($rateModel->getLatitude());
        $extensionAttributes->setLongitude($rateModel->getLongitude());

        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }
}
