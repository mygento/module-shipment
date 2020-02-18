<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

interface CalculateRequestInterface
{
    const CITY = 'city';
    const INDEX = 'index';
    const REGION_NAME = 'region_name';
    const REGION_CODE = 'region_code';
    const WEIGHT = 'weight';
    const ORDER_SUM = 'order_sum';
    const RAW_REQUEST = 'raw_request';

    /**
     * Get city
     * @return string|null
     */
    public function getCity();

    /**
     * Set city
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * Get index
     * @return string|null
     */
    public function getIndex();

    /**
     * Set index
     * @param string $index
     * @return $this
     */
    public function setIndex($index);

    /**
     * Get region name
     * @return string|null
     */
    public function getRegionName();

    /**
     * Set region name
     * @param string $regionName
     * @return $this
     */
    public function setRegionName($regionName);

    /**
     * Get region code
     * @return string|null
     */
    public function getRegionCode();

    /**
     * Set region code
     * @param string $regionCode
     * @return $this
     */
    public function setRegionCode($regionCode);

    /**
     * Get weight
     * @return float|null
     */
    public function getWeight();

    /**
     * Set weight
     * @param float $weight
     * @return $this
     */
    public function setWeight($weight);

    /**
     * Get order sum
     * @return float|null
     */
    public function getOrderSum();

    /**
     * Set order sum
     * @param float $orderSum
     * @return $this
     */
    public function setOrderSum($orderSum);

    /**
     * Get raw request
     * @return \Magento\Quote\Model\Quote\Address\RateRequest|null
     */
    public function getRawRequest();

    /**
     * Set raw request
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $rawRequest
     * @return $this
     */
    public function setRawRequest($rawRequest);
}
