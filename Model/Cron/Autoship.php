<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Cron;

use Magento\Framework\Data\Collection;
use Magento\Sales\Api\Data\OrderInterface;

class Autoship implements \Mygento\Shipment\Api\Service\AutoshipInterface
{
    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    private $sortBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $builder;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    private $repo;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $repo
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $builder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SortOrderBuilder $sortBuilder
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $repo,
        \Magento\Framework\Api\SearchCriteriaBuilder $builder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortBuilder
    ) {
        $this->repo = $repo;
        $this->builder = $builder;
        $this->filterBuilder = $filterBuilder;
        $this->sortBuilder = $sortBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getOrdersByStatuses(array $statuses, array $filters = [], $storeId = null)
    {
        $this->builder->addFilter(OrderInterface::STATUS, $statuses, 'in');
        if (!empty($filters)) {
            $this->builder->addFilters($filters);
        }
        if ($storeId !== null) {
            $this->builder->addFilter(OrderInterface::STORE_ID, $storeId);
        }
        $createdAtSort = $this->sortBuilder
            ->setField(OrderInterface::CREATED_AT)
            ->setDirection(Collection::SORT_ORDER_DESC)
            ->create();
        $this->builder->addSortOrder($createdAtSort);

        return $this->repo->getList($this->builder->create())->getItems();
    }

    /**
     * @inheritdoc
     */
    public function createFilter(string $field, $value, string $condition = 'eq')
    {
        return $this->filterBuilder
            ->setField($field)
            ->setConditionType($condition)
            ->setValue($value)
            ->create();
    }
}
