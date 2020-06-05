<?php
namespace Serj\VoucherApi\Model\ResourceModel\VoucherStatus;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Serj\VoucherApi\Model\VoucherStatus as Model;
use Serj\VoucherApi\Model\ResourceModel\VoucherStatus as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'serj_voucherapi_voucherstatus_collection';
	protected $_eventObject = 'voucherstatus_collection';

	/**
	 * @inheritdoc
	 */
	protected function _construct()
	{
		$this->_init(Model::class, ResourceModel::class);
	}

    public function filterByStatusCode($statusCode)
    {
        $this->addFieldToFilter('status_code', $statusCode);

        return $this;
    }
}
