<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Service;

use Magento\Framework\DataObject;
use Mygento\Shipment\Api\Data\CalculateRequestInterface;

class CalculateRequest extends DataObject implements CalculateRequestInterface
{
    /**
     * Get city
     * @return string|null
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * Set city
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Get index
     * @return string|null
     */
    public function getIndex()
    {
        return $this->getData(self::INDEX);
    }

    /**
     * Set index
     * @param string $index
     * @return $this
     */
    public function setIndex($index)
    {
        return $this->setData(self::INDEX, $index);
    }

    /**
     * Get region name
     * @return string|null
     */
    public function getRegionName()
    {
        return $this->getData(self::REGION_NAME);
    }

    /**
     * Set region name
     * @param string $regionName
     * @return $this
     */
    public function setRegionName($regionName)
    {
        return $this->setData(self::REGION_NAME, $regionName);
    }

    /**
     * Get region code
     * @return string|null
     */
    public function getRegionCode()
    {
        return $this->getData(self::REGION_CODE);
    }

    /**
     * Set region code
     * @param string $regionCode
     * @return $this
     */
    public function setRegionCode($regionCode)
    {
        return $this->setData(self::REGION_CODE, $regionCode);
    }

    /**
     * Get weight
     * @return float|null
     */
    public function getWeight()
    {
        return $this->getData(self::WEIGHT);
    }

    /**
     * Set weight
     * @param float $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        return $this->setData(self::WEIGHT, $weight);
    }

    /**
     * Get order sum
     * @return float|null
     */
    public function getOrderSum()
    {
        return $this->getData(self::ORDER_SUM);
    }

    /**
     * Set order sum
     * @param float $orderSum
     * @return $this
     */
    public function setOrderSum($orderSum)
    {
        return $this->setData(self::ORDER_SUM, $orderSum);
    }

    /**
     * Get raw request
     * @return \Magento\Quote\Model\Quote\Address\RateRequest|null
     */
    public function getRawRequest()
    {
        return $this->getData(self::RAW_REQUEST);
    }

    /**
     * Set raw request
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $rawRequest
     * @return $this
     */
    public function setRawRequest($rawRequest)
    {
        return $this->setData(self::RAW_REQUEST, $rawRequest);
    }
}
