<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model\Point;

use Magento\Framework\App\Request\DataPersistorInterface;
use Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /** @var \Mygento\Shipment\Model\ResourceModel\Point\Collection */
    protected $collection;

    /** @var DataPersistorInterface */
    protected $dataPersistor;

    /** @var array */
    protected $loadedData;

    /**
     * @param \Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('shipment_point');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('shipment_point');
        }

        return $this->loadedData;
    }
}
