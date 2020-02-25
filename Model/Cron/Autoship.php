<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Cron;

use Magento\Sales\Api\Data\OrderInterface;

class Autoship implements \Mygento\Shipment\Api\Service\AutoshipInterface
{
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
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $repo,
        \Magento\Framework\Api\SearchCriteriaBuilder $builder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->repo = $repo;
        $this->builder = $builder;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @param string[] $statuses
     * @param \Magento\Framework\Api\Filter[] $filters
     * @return []
     */
    public function getOrdersByStatuses(array $statuses, array $filters = [])
    {
        $this->builder->addFilter(OrderInterface::STATUS, $statuses, 'in');
        if (!empty($filters)) {
            $this->builder->addFilters($filters);
        }

        return $this->repo->getList($this->builder->create())->getItems();
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string $condition
     * @return \Magento\Framework\Api\Filter
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
