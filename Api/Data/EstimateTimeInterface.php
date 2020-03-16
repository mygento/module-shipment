<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Data;

interface EstimateTimeInterface
{
    const FROM = 'from';
    const TO = 'to';

    /**
     * Get from
     * @return string|null
     */
    public function getFrom();

    /**
     * Set from
     * @param string $time
     * @return $this
     */
    public function setFrom(string $time);

    /**
     * Get to
     * @return string|null
     */
    public function getTo();

    /**
     * Set to
     * @param string $time
     * @return $this
     */
    public function setTo(string $time);
}
