<?php

namespace Serj\VoucherApi\Model\Data\Providers;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class VoucherForm extends AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $customerCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $customerCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $data = $this->collection->addFieldToSelect('id');
        var_dump($data); exit();

        return $data;
    }
}
