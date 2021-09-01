<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

use Magento\Framework\Serialize\Serializer\Json;

class ExtShippingMethodManagement
{
    /**
     * @var \Magento\Quote\Api\Data\ShippingMethodExtensionFactory
     */
    private $shippingExtAttr;

    /**
     * @var Json
     */
    private $json;

    /**
     * @param \Magento\Quote\Api\Data\ShippingMethodExtensionFactory $shippingExtAttr
     * @param Json $json
     */
    public function __construct(
        \Magento\Quote\Api\Data\ShippingMethodExtensionFactory $shippingExtAttr,
        Json $json
    ) {
        $this->shippingExtAttr = $shippingExtAttr;
        $this->json = $json;
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

        $extensionAttributes->setEstimateDate($this->unserializeEstimate($rateModel->getEstimateDate()));
        $extensionAttributes->setEstimateTime($this->unserializeEstimate($rateModel->getEstimateTime()));
        $extensionAttributes->setEstimate($rateModel->getEstimate());

        $extensionAttributes->setPickupPoints($rateModel->getPickupPoints());
        $extensionAttributes->setDescription($rateModel->getDescription());
        // deprecated
        $extensionAttributes->setLatitude($rateModel->getLatitude());
        $extensionAttributes->setLongitude($rateModel->getLongitude());

        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    /**
     * @param array|string $estimate
     * @return mixed
     */
    private function unserializeEstimate($estimate)
    {
        if (is_string($estimate)) {
            try {
                $estimate = $this->json->unserialize($estimate);
            } catch (\Exception $e) {
                $estimate = [];
            }
        }

        return $estimate;
    }
}
