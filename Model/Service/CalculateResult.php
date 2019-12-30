<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Service;

use Magento\Framework\DataObject;

class CalculateResult extends DataObject implements \Mygento\Shipment\Api\Data\CalculateResultInterface
{
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
     * Get estimate
     * @return string|null
     */
    public function getEstimate()
    {
        return $this->getData(self::ESTIMATE);
    }

    /**
     * Set estimate
     * @param string $estimate
     * @return $this
     */
    public function setEstimate($estimate)
    {
        return $this->setData(self::ESTIMATE, $estimate);
    }

    /**
     * Get estimate dates
     * @return array|null
     */
    public function getEstimateDates()
    {
        return $this->getData(self::ESTIMATE_DATES);
    }

    /**
     * Set estimate dates
     * @param array $estimateDates
     * @return $this
     */
    public function setEstimateDates($estimateDates)
    {
        return $this->setData(self::ESTIMATE_DATES, $estimateDates);
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
}
