<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Estimate;

use Magento\Framework\DataObject;
use Mygento\Shipment\Api\Data\EstimateTimeInterface;

class Time extends DataObject implements EstimateTimeInterface
{
    /**
     * Get from
     * @return string|null
     */
    public function getFrom()
    {
        return $this->getData(self::FROM);
    }

    /**
     * Get to
     * @return string|null
     */
    public function getTo()
    {
        return $this->getData(self::TO);
    }

    /**
     * Set from
     * @param string $time
     * @return $this
     */
    public function setFrom(string $time)
    {
        return $this->setData(self::FROM, $time);
    }

    /**
     * Set to
     * @param string $time
     * @return $this
     */
    public function setTo(string $time)
    {
        return $this->setData(self::TO, $time);
    }

    /**
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize(): mixed
    {
        return $this->getData();
    }
}
