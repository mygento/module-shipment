<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

interface CalculateResultInterface
{
    public const CARRIER = 'carrier';
    public const CARRIER_TITLE = 'carrier_title';
    public const METHOD = 'method';
    public const METHOD_TITLE = 'method_title';
    public const DESCRIPTION = 'description';
    public const PRICE = 'price';
    public const COST = 'cost';
    public const ESTIMATE_DATE = 'estimate_date';
    public const ESTIMATE_TIME = 'estimate_time';
    public const ESTIMATE = 'estimate';
    public const PICKUP_POINTS = 'pickup_points';
    public const LATITUDE = 'latitude';
    public const ERROR = 'error';
    public const ERROR_MESSAGE = 'error_message';
    public const LONGITUDE = 'longitude';

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
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

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
     * Get estimate date
     * @return string[]|null
     */
    public function getEstimateDate();

    /**
     * Set estimate date
     * @param string[] $estimateDate
     * @return $this
     */
    public function setEstimateDate($estimateDate);

    /**
     * Get estimate time
     * @return string[]|null
     */
    public function getEstimateTime();

    /**
     * Set estimate time
     * @param string[] $estimateTime
     * @return $this
     */
    public function setEstimateTime($estimateTime);

    /**
     * Get estimate
     * @return int|null
     */
    public function getEstimate();

    /**
     * Set estimate
     * @param int $estimate
     * @return $this
     */
    public function setEstimate($estimate);

    /**
     * Get pickup points
     * @return \Mygento\Shipment\Api\Data\PointInterface[]|null
     */
    public function getPickupPoints();

    /**
     * Set pickup points
     * @param \Mygento\Shipment\Api\Data\PointInterface[] $pickupPoints
     * @return $this
     */
    public function setPickupPoints($pickupPoints);

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
     * Get error
     * @return bool|null
     */
    public function getError();

    /**
     * Set error
     * @param bool $error
     * @return $this
     */
    public function setError($error);

    /**
     * Get error message
     * @return string|null
     */
    public function getErrorMessage();

    /**
     * Set error message
     * @param string $errorMessage
     * @return $this
     */
    public function setErrorMessage($errorMessage);

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
}
