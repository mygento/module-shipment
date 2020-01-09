<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

interface PointInterface
{
    const ID = 'id';
    const IS_ACTIVE = 'is_active';
    const PROVIDER = 'provider';
    const PROVIDER_UID = 'provider_uid';
    const PRIORITY = 'priority';
    const TYPE = 'type';
    const COUNTRY_ID = 'country_id';
    const CITY_ID = 'city_id';
    const CITY = 'city';
    const STREET = 'street';
    const NAME = 'name';
    const ADDRESS = 'address';
    const ADDRESS_DESCRIPTION = 'address_description';
    const DESCRIPTION = 'description';
    const POSTCODE = 'postcode';
    const PHONE_NUMBER = 'phone_number';
    const SCHEDULE = 'schedule';
    const WORKING_HOURS = 'working_hours';
    const IMAGE = 'image';
    const SORT_ORDER = 'sort_order';
    const LATITUDE = 'latitude';
    const LONGITUDE = 'longitude';
    const CASH_DELIVERY = 'cash_delivery';
    const CARD_DELIVERY = 'card_delivery';
    const ONLINE_PREPAID = 'online_prepaid';
    const TWENTY_FOUR_HOURS = 'twenty_four_hours';
    const TESTING_AVAILABLE = 'testing_available';
    const ICON = 'icon';
    const PRICE = 'price';

    /**
     * Get id
     * @return int|null
     */
    public function getId();

    /**
     * Set id
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get is active
     * @return bool|null
     */
    public function getIsActive();

    /**
     * Set is active
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get provider
     * @return string|null
     */
    public function getProvider();

    /**
     * Set provider
     * @param string $provider
     * @return $this
     */
    public function setProvider($provider);

    /**
     * Get provider uid
     * @return string|null
     */
    public function getProviderUid();

    /**
     * Set provider uid
     * @param string $providerUid
     * @return $this
     */
    public function setProviderUid($providerUid);

    /**
     * Get priority
     * @return int|null
     */
    public function getPriority();

    /**
     * Set priority
     * @param int $priority
     * @return $this
     */
    public function setPriority($priority);

    /**
     * Get type
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return $this
     */
    public function setType($type);

    /**
     * Get country id
     * @return string|null
     */
    public function getCountryId();

    /**
     * Set country id
     * @param string $countryId
     * @return $this
     */
    public function setCountryId($countryId);

    /**
     * Get city id
     * @return int|null
     */
    public function getCityId();

    /**
     * Set city id
     * @param int $cityId
     * @return $this
     */
    public function setCityId($cityId);

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
     * Get street
     * @return string|null
     */
    public function getStreet();

    /**
     * Set street
     * @param string $street
     * @return $this
     */
    public function setStreet($street);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get address
     * @return string|null
     */
    public function getAddress();

    /**
     * Set address
     * @param string $address
     * @return $this
     */
    public function setAddress($address);

    /**
     * Get address description
     * @return string|null
     */
    public function getAddressDescription();

    /**
     * Set address description
     * @param string $addressDescription
     * @return $this
     */
    public function setAddressDescription($addressDescription);

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
     * Get postcode
     * @return string|null
     */
    public function getPostcode();

    /**
     * Set postcode
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode);

    /**
     * Get phone number
     * @return string|null
     */
    public function getPhoneNumber();

    /**
     * Set phone number
     * @param string $phoneNumber
     * @return $this
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * Get schedule
     * @return string|null
     */
    public function getSchedule();

    /**
     * Set schedule
     * @param string $schedule
     * @return $this
     */
    public function setSchedule($schedule);

    /**
     * Get working hours
     * @return string|null
     */
    public function getWorkingHours();

    /**
     * Set working hours
     * @param string $workingHours
     * @return $this
     */
    public function setWorkingHours($workingHours);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Get sort order
     * @return int|null
     */
    public function getSortOrder();

    /**
     * Set sort order
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * Get latitude
     * @return float|null
     */
    public function getLatitude();

    /**
     * Set latitude
     * @param float $latitude
     * @return $this
     */
    public function setLatitude($latitude);

    /**
     * Get longitude
     * @return float|null
     */
    public function getLongitude();

    /**
     * Set longitude
     * @param float $longitude
     * @return $this
     */
    public function setLongitude($longitude);

    /**
     * Get cash delivery
     * @return bool|null
     */
    public function getCashDelivery();

    /**
     * Set cash delivery
     * @param bool $cashDelivery
     * @return $this
     */
    public function setCashDelivery($cashDelivery);

    /**
     * Get card delivery
     * @return bool|null
     */
    public function getCardDelivery();

    /**
     * Set card delivery
     * @param bool $cardDelivery
     * @return $this
     */
    public function setCardDelivery($cardDelivery);

    /**
     * Get online prepaid
     * @return bool|null
     */
    public function getOnlinePrepaid();

    /**
     * Set online prepaid
     * @param bool $onlinePrepaid
     * @return $this
     */
    public function setOnlinePrepaid($onlinePrepaid);

    /**
     * Get twenty four hours
     * @return bool|null
     */
    public function getTwentyFourHours();

    /**
     * Set twenty four hours
     * @param bool $twentyFourHours
     * @return $this
     */
    public function setTwentyFourHours($twentyFourHours);

    /**
     * Get testing available
     * @return bool|null
     */
    public function getTestingAvailable();

    /**
     * Set testing available
     * @param bool $testingAvailable
     * @return $this
     */
    public function setTestingAvailable($testingAvailable);

    /**
     * Get icon
     * @return string|null
     */
    public function getIcon();

    /**
     * Set icon
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon);

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
}
