<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Data\Collection;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PointRepository implements \Mygento\Shipment\Api\PointRepositoryInterface
{
    /** @var \Mygento\Shipment\Model\ResourceModel\Point */
    private $resource;

    /** @var \Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory */
    private $collectionFactory;

    /** @var \Mygento\Shipment\Api\Data\PointInterfaceFactory */
    private $entityFactory;

    /** @var \Mygento\Shipment\Api\Data\PointSearchResultsInterfaceFactory */
    private $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     **/
    private $collectionProcessor;

    /**
     * PointRepository constructor.
     * @param ResourceModel\Point $resource
     * @param ResourceModel\Point\CollectionFactory $collectionFactory
     * @param \Mygento\Shipment\Api\Data\PointInterfaceFactory $entityFactory
     * @param \Mygento\Shipment\Api\Data\PointSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceModel\Point $resource,
        ResourceModel\Point\CollectionFactory $collectionFactory,
        \Mygento\Shipment\Api\Data\PointInterfaceFactory $entityFactory,
        \Mygento\Shipment\Api\Data\PointSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->entityFactory = $entityFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function getById($entityId)
    {
        $entity = $this->entityFactory->create();
        $this->resource->load($entity, $entityId);
        if (!$entity->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Shipment Point with id "%1" does not exist.', $entityId)
            );
        }

        return $entity;
    }

    /**
     * @param \Mygento\Shipment\Api\Data\PointInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return \Mygento\Shipment\Api\Data\PointInterface
     */
    public function save(\Mygento\Shipment\Api\Data\PointInterface $entity)
    {
        try {
            $this->resource->save($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __($exception->getMessage())
            );
        }

        return $entity;
    }

    /**
     * @param \Mygento\Shipment\Api\Data\PointInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function delete(\Mygento\Shipment\Api\Data\PointInterface $entity)
    {
        try {
            $this->resource->delete($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(
                __($exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Mygento\Shipment\Api\Data\PointSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Mygento\Shipment\Model\ResourceModel\Point\Collection $collection */
        $collection = $this->collectionFactory->create();
        $sortOrders = $criteria->getSortOrders();
        $sortAsc = SortOrder::SORT_ASC;
        $orderAsc = Collection::SORT_ORDER_ASC;
        $orderDesc = Collection::SORT_ORDER_DESC;
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == $sortAsc) ? $orderAsc : $orderDesc
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());

        if ($this->collectionProcessor) {
            $this->collectionProcessor->process($criteria, $collection);
        }

        /** @var \Mygento\Shipment\Api\Data\PointSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
