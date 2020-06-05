<?php
namespace Serj\VoucherApi\Model\ResourceModel\Voucher;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Serj\VoucherApi\Model\Voucher as Model;
use Serj\VoucherApi\Model\ResourceModel\Voucher as ResourceModel;

class Collection extends AbstractCollection
{
	protected $_idFieldName = 'entity_id';
	protected $_eventPrefix = 'serj_voucherapi_voucher_collection';
	protected $_eventObject = 'voucher_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(Model::class, ResourceModel::class);
	}

    public function filterByCustomerId($customerId)
    {
        $this->addFieldToFilter('customer_id', $customerId);

        return $this;
    }
}
