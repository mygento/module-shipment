<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @api
 */
interface PointRepositoryInterface
{
    /**
     * Save Point
     * @param \Mygento\Shipment\Api\Data\PointInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function save(Data\PointInterface $entity): Data\PointInterface;

    /**
     * Retrieve Point
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function getById(int $entityId): Data\PointInterface;

    /**
     * Retrieve Point entities matching the specified criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Mygento\Shipment\Api\Data\PointSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): Data\PointSearchResultsInterface;

    /**
     * Delete Point
     * @param \Mygento\Shipment\Api\Data\PointInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function delete(Data\PointInterface $entity): bool;

    /**
     * Delete Point
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function deleteById(int $entityId): bool;
}
