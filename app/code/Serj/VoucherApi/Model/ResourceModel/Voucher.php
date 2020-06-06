<?php
namespace Serj\VoucherApi\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Serj\VoucherApi\Api\Data\VoucherInterface;

/**
 * Class Voucher
 */
class Voucher extends AbstractDb
{
    /**
     * Constants
     * @var string
     */
    const TABLE_NAME = 'voucher';

	public function __construct(
		Context $context
	)
	{
		parent::__construct($context);
	}

	protected function _construct()
	{
		$this->_init(self::TABLE_NAME, VoucherInterface::ID);
	}

}
