<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class Point extends AbstractModel implements \Mygento\Shipment\Api\Data\PointInterface
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getProvider() . '_' . $this->getProviderUid();
    }

    /**
     * Get id
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get is active
     * @return bool|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is active
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get provider
     * @return string|null
     */
    public function getProvider()
    {
        return $this->getData(self::PROVIDER);
    }

    /**
     * Set provider
     * @param string $provider
     * @return $this
     */
    public function setProvider($provider)
    {
        return $this->setData(self::PROVIDER, $provider);
    }

    /**
     * Get provider uid
     * @return string|null
     */
    public function getProviderUid()
    {
        return $this->getData(self::PROVIDER_UID);
    }

    /**
     * Set provider uid
     * @param string $providerUid
     * @return $this
     */
    public function setProviderUid($providerUid)
    {
        return $this->setData(self::PROVIDER_UID, $providerUid);
    }

    /**
     * Get priority
     * @return int|null
     */
    public function getPriority()
    {
        return $this->getData(self::PRIORITY);
    }

    /**
     * Set priority
     * @param int $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        return $this->setData(self::PRIORITY, $priority);
    }

    /**
     * Get type
     * @return string|null
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set type
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get country id
     * @return string|null
     */
    public function getCountryId()
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * Set country id
     * @param string $countryId
     * @return $this
     */
    public function setCountryId($countryId)
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * Get region
     * @return string|null
     */
    public function getRegion()
    {
        return $this->getData(self::REGION);
    }

    /**
     * Set region
     * @param string $region
     * @return $this
     */
    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * Get region id
     * @return int|null
     */
    public function getRegionId()
    {
        return $this->getData(self::REGION_ID);
    }

    /**
     * Set region id
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId)
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    /**
     * Get city id
     * @return int|null
     */
    public function getCityId()
    {
        return $this->getData(self::CITY_ID);
    }

    /**
     * Set city id
     * @param int $cityId
     * @return $this
     */
    public function setCityId($cityId)
    {
        return $this->setData(self::CITY_ID, $cityId);
    }

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
     * Get street
     * @return string|null
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * Set street
     * @param string $street
     * @return $this
     */
    public function setStreet($street)
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get address
     * @return string|null
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Set address
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Get address description
     * @return string|null
     */
    public function getAddressDescription()
    {
        return $this->getData(self::ADDRESS_DESCRIPTION);
    }

    /**
     * Set address description
     * @param string $addressDescription
     * @return $this
     */
    public function setAddressDescription($addressDescription)
    {
        return $this->setData(self::ADDRESS_DESCRIPTION, $addressDescription);
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
     * Get postcode
     * @return string|null
     */
    public function getPostcode()
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * Set postcode
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * Get phone number
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->getData(self::PHONE_NUMBER);
    }

    /**
     * Set phone number
     * @param string $phoneNumber
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        return $this->setData(self::PHONE_NUMBER, $phoneNumber);
    }

    /**
     * Get schedule
     * @return string|null
     */
    public function getSchedule()
    {
        return $this->getData(self::SCHEDULE);
    }

    /**
     * Set schedule
     * @param string $schedule
     * @return $this
     */
    public function setSchedule($schedule)
    {
        return $this->setData(self::SCHEDULE, $schedule);
    }

    /**
     * Get working hours
     * @return string|null
     */
    public function getWorkingHours()
    {
        return $this->getData(self::WORKING_HOURS);
    }

    /**
     * Set working hours
     * @param string $workingHours
     * @return $this
     */
    public function setWorkingHours($workingHours)
    {
        return $this->setData(self::WORKING_HOURS, $workingHours);
    }

    /**
     * Get max size
     * @return float|null
     */
    public function getMaxSize()
    {
        return $this->getData(self::MAX_SIZE);
    }

    /**
     * Set max size
     * @param float $maxSize
     * @return $this
     */
    public function setMaxSize($maxSize)
    {
        return $this->setData(self::MAX_SIZE, $maxSize);
    }

    /**
     * Get min weight
     * @return float|null
     */
    public function getMinWeight()
    {
        return $this->getData(self::MIN_WEIGHT);
    }

    /**
     * Set min weight
     * @param float $minWeight
     * @return $this
     */
    public function setMinWeight($minWeight)
    {
        return $this->setData(self::MIN_WEIGHT, $minWeight);
    }

    /**
     * Get max weight
     * @return float|null
     */
    public function getMaxWeight()
    {
        return $this->getData(self::MAX_WEIGHT);
    }

    /**
     * Set max weight
     * @param float $maxWeight
     * @return $this
     */
    public function setMaxWeight($maxWeight)
    {
        return $this->setData(self::MAX_WEIGHT, $maxWeight);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get sort order
     * @return int|null
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Set sort order
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * Get latitude
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->getData(self::LATITUDE);
    }

    /**
     * Set latitude
     * @param float $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        return $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * Get longitude
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->getData(self::LONGITUDE);
    }

    /**
     * Set longitude
     * @param float $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        return $this->setData(self::LONGITUDE, $longitude);
    }

    /**
     * Get cash delivery
     * @return bool|null
     */
    public function getCashDelivery()
    {
        return $this->getData(self::CASH_DELIVERY);
    }

    /**
     * Set cash delivery
     * @param bool $cashDelivery
     * @return $this
     */
    public function setCashDelivery($cashDelivery)
    {
        return $this->setData(self::CASH_DELIVERY, $cashDelivery);
    }

    /**
     * Get card delivery
     * @return bool|null
     */
    public function getCardDelivery()
    {
        return $this->getData(self::CARD_DELIVERY);
    }

    /**
     * Set card delivery
     * @param bool $cardDelivery
     * @return $this
     */
    public function setCardDelivery($cardDelivery)
    {
        return $this->setData(self::CARD_DELIVERY, $cardDelivery);
    }

    /**
     * Get prepaid only
     * @return bool|null
     */
    public function getPrepaidOnly()
    {
        return $this->getData(self::PREPAID_ONLY);
    }

    /**
     * Set prepaid only
     * @param bool $prepaidOnly
     * @return $this
     */
    public function setPrepaidOnly($prepaidOnly)
    {
        return $this->setData(self::PREPAID_ONLY, $prepaidOnly);
    }

    /**
     * Get twenty four hours
     * @return bool|null
     */
    public function getTwentyFourHours()
    {
        return $this->getData(self::TWENTY_FOUR_HOURS);
    }

    /**
     * Set twenty four hours
     * @param bool $twentyFourHours
     * @return $this
     */
    public function setTwentyFourHours($twentyFourHours)
    {
        return $this->setData(self::TWENTY_FOUR_HOURS, $twentyFourHours);
    }

    /**
     * Get testing available
     * @return bool|null
     */
    public function getTestingAvailable()
    {
        return $this->getData(self::TESTING_AVAILABLE);
    }

    /**
     * Set testing available
     * @param bool $testingAvailable
     * @return $this
     */
    public function setTestingAvailable($testingAvailable)
    {
        return $this->setData(self::TESTING_AVAILABLE, $testingAvailable);
    }

    /**
     * Get icon
     * @return string|null
     */
    public function getIcon()
    {
        return $this->getData(self::ICON);
    }

    /**
     * Set icon
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        return $this->setData(self::ICON, $icon);
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
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mygento\Shipment\Model\ResourceModel\Point::class);
    }
}
