<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api;

interface PointRepositoryInterface
{
    /**
     * Save Point
     * @param \Mygento\Shipment\Api\Data\PointInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function save(Data\PointInterface $entity);

    /**
     * Retrieve Point
     * @param int $entityId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function getById($entityId);

    /**
     * Retrieve Point entities matching the specified criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Mygento\Shipment\Api\Data\PointSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Point
     * @param \Mygento\Shipment\Api\Data\PointInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function delete(Data\PointInterface $entity);

    /**
     * Delete Point
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function deleteById($entityId);
}
