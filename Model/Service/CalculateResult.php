<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Service;

use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\DataObject;
use Mygento\Shipment\Api\Data\CalculateResultExtensionInterface;

class CalculateResult extends DataObject implements \Mygento\Shipment\Api\Data\CalculateResultInterface
{
    /**
     * @var ExtensionAttributesFactory
     */
    protected $extensionAttributesFactory;

    public function __construct(
        ExtensionAttributesFactory $extensionFactory,
        array $data = []
    ) {
        $this->extensionAttributesFactory = $extensionFactory;
        parent::__construct($data);
        if (isset($data[self::EXTENSION_ATTRIBUTES_KEY]) && is_array($data[self::EXTENSION_ATTRIBUTES_KEY])) {
            $this->populateExtensionAttributes($data[self::EXTENSION_ATTRIBUTES_KEY]);
        }
    }

    /**
     * Get carrier
     * @return string|null
     */
    public function getCarrier()
    {
        return $this->getData(self::CARRIER);
    }

    /**
     * Set carrier
     * @param string $carrier
     * @return $this
     */
    public function setCarrier($carrier)
    {
        return $this->setData(self::CARRIER, $carrier);
    }

    /**
     * Get carrier title
     * @return string|null
     */
    public function getCarrierTitle()
    {
        return $this->getData(self::CARRIER_TITLE);
    }

    /**
     * Set carrier title
     * @param string $carrierTitle
     * @return $this
     */
    public function setCarrierTitle($carrierTitle)
    {
        return $this->setData(self::CARRIER_TITLE, $carrierTitle);
    }

    /**
     * Get method
     * @return string|null
     */
    public function getMethod()
    {
        return $this->getData(self::METHOD);
    }

    /**
     * Set method
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        return $this->setData(self::METHOD, $method);
    }

    /**
     * Get method title
     * @return string|null
     */
    public function getMethodTitle()
    {
        return $this->getData(self::METHOD_TITLE);
    }

    /**
     * Set method title
     * @param string $methodTitle
     * @return $this
     */
    public function setMethodTitle($methodTitle)
    {
        return $this->setData(self::METHOD_TITLE, $methodTitle);
    }

    /**
     * Get description
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get price
     * @return float|null
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * Set price
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * Get cost
     * @return float|null
     */
    public function getCost()
    {
        return $this->getData(self::COST);
    }

    /**
     * Set cost
     * @param float $cost
     * @return $this
     */
    public function setCost($cost)
    {
        return $this->setData(self::COST, $cost);
    }

    /**
     * Get estimate date
     * @return string[]|null
     */
    public function getEstimateDate()
    {
        return $this->getData(self::ESTIMATE_DATE);
    }

    /**
     * Set estimate date
     * @param string[] $estimateDate
     * @return $this
     */
    public function setEstimateDate($estimateDate)
    {
        return $this->setData(self::ESTIMATE_DATE, $estimateDate);
    }

    /**
     * Get estimate time
     * @return string[]|null
     */
    public function getEstimateTime()
    {
        return $this->getData(self::ESTIMATE_TIME);
    }

    /**
     * Set estimate time
     * @param string[] $estimateTime
     * @return $this
     */
    public function setEstimateTime($estimateTime)
    {
        return $this->setData(self::ESTIMATE_TIME, $estimateTime);
    }

    /**
     * Get estimate
     * @return int|null
     */
    public function getEstimate()
    {
        return $this->getData(self::ESTIMATE);
    }

    /**
     * Set estimate
     * @param int $estimate
     * @return $this
     */
    public function setEstimate($estimate)
    {
        return $this->setData(self::ESTIMATE, $estimate);
    }

    /**
     * Get pickup points
     * @return \Mygento\Shipment\Api\Data\PointInterface[]|null
     */
    public function getPickupPoints()
    {
        return $this->getData(self::PICKUP_POINTS);
    }

    /**
     * Set pickup points
     * @param \Mygento\Shipment\Api\Data\PointInterface[] $pickupPoints
     * @return $this
     */
    public function setPickupPoints($pickupPoints)
    {
        return $this->setData(self::PICKUP_POINTS, $pickupPoints);
    }

    /**
     * Get latitude
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->getData(self::LATITUDE);
    }

    /**
     * Set latitude
     * @param string $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        return $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * Get error
     * @return bool|null
     */
    public function getError()
    {
        return $this->getData(self::ERROR);
    }

    /**
     * Set error
     * @param bool $error
     * @return $this
     */
    public function setError($error)
    {
        return $this->setData(self::ERROR, $error);
    }

    /**
     * Get error message
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->getData(self::ERROR_MESSAGE);
    }

    /**
     * Set error message
     * @param string $errorMessage
     * @return $this
     */
    public function setErrorMessage($errorMessage)
    {
        return $this->setData(self::ERROR_MESSAGE, $errorMessage);
    }

    /**
     * Get longitude
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->getData(self::LONGITUDE);
    }

    /**
     * Set longitude
     * @param string $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        return $this->setData(self::LONGITUDE, $longitude);
    }

    public function getExtensionAttributes()
    {
        if (!$this->getData(self::EXTENSION_ATTRIBUTES_KEY)) {
            $this->populateExtensionAttributes([]);
        }

        return $this->getData(self::EXTENSION_ATTRIBUTES_KEY);
    }

    public function setExtensionAttributes(CalculateResultExtensionInterface $extensionAttributes)
    {
        $this->setData(self::EXTENSION_ATTRIBUTES_KEY, $extensionAttributes);

        return $this;
    }

    /**
     * Instantiate extension attributes object and populate it with the provided data.
     *
     * @param array $extensionAttributesData
     * @return void
     */
    private function populateExtensionAttributes(array $extensionAttributesData = [])
    {
        $extensionAttributes = $this->extensionAttributesFactory->create(get_class($this), $extensionAttributesData);
        $this->setExtensionAttributes($extensionAttributes);
    }
}
