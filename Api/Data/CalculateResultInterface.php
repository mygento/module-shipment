<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

interface CalculateResultInterface
{
    const CARRIER = 'carrier';
    const CARRIER_TITLE = 'carrier_title';
    const METHOD = 'method';
    const METHOD_TITLE = 'method_title';
    const PRICE = 'price';
    const COST = 'cost';
    const ESTIMATE = 'estimate';
    const ESTIMATE_DATES = 'estimate_dates';
    const LATITUDE = 'latitude';
    const LONGITUDE = 'longitude';
    const PICKUP_POINTS = 'pickup_points';

    /**
     * Get carrier
     * @return string|null
     */
    public function getCarrier();

    /**
     * Set carrier
     * @param string $carrier
     * @return $this
     */
    public function setCarrier($carrier);

    /**
     * Get carrier title
     * @return string|null
     */
    public function getCarrierTitle();

    /**
     * Set carrier title
     * @param string $carrierTitle
     * @return $this
     */
    public function setCarrierTitle($carrierTitle);

    /**
     * Get method
     * @return string|null
     */
    public function getMethod();

    /**
     * Set method
     * @param string $method
     * @return $this
     */
    public function setMethod($method);

    /**
     * Get method title
     * @return string|null
     */
    public function getMethodTitle();

    /**
     * Set method title
     * @param string $methodTitle
     * @return $this
     */
    public function setMethodTitle($methodTitle);

    /**
     * Get price
     * @return float|null
     */
    public function getPrice();

    /**
     * Set price
     * @param float $price
     * @return $this
     */
    public function setPrice($price);

    /**
     * Get cost
     * @return float|null
     */
    public function getCost();

    /**
     * Set cost
     * @param float $cost
     * @return $this
     */
    public function setCost($cost);

    /**
     * Get estimate
     * @return string|null
     */
    public function getEstimate();

    /**
     * Set estimate
     * @param string $estimate
     * @return $this
     */
    public function setEstimate($estimate);

    /**
     * Get estimate dates
     * @return array|null
     */
    public function getEstimateDates();

    /**
     * Set estimate dates
     * @param array $estimateDates
     * @return $this
     */
    public function setEstimateDates($estimateDates);

    /**
     * Get latitude
     * @return string|null
     */
    public function getLatitude();

    /**
     * Set latitude
     * @param string $latitude
     * @return $this
     */
    public function setLatitude($latitude);

    /**
     * Get longitude
     * @return string|null
     */
    public function getLongitude();

    /**
     * Set longitude
     * @param string $longitude
     * @return $this
     */
    public function setLongitude($longitude);

    /**
     * Get pickup points
     * @return \Mygento\Shipment\Api\Data\PointInterface[]|null
     */
    public function getPickupPoints();

    /**
     * Set pickup points
     * @param Mygento\Shipment\Api\Data\PointInterface[] $pickupPoints
     * @return $this
     */
    public function setPickupPoints($pickupPoints);
}
