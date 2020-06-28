<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Serj\VoucherApi\Model\Data\AttributeSet;

use Serj\VoucherApi\Api\VoucherStatusRepositoryInterface;

/**
 * Customer group attribute source
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class VoucherStatus extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    /**
     * @var VoucherStatusRepositoryInterface
     */
    private $voucherStatusRepository;

    /**
     * @var \Magento\Framework\Convert\DataObject
     */
    protected $_converter;

    /**
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory
     * @param VoucherStatusRepositoryInterface $voucherStatusRepository
     * @param \Magento\Framework\Convert\DataObject $converter
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        VoucherStatusRepositoryInterface $voucherStatusRepository,
        \Magento\Framework\Convert\DataObject $converter
    ) {
        $this->voucherStatusRepository = $voucherStatusRepository;
        $this->_converter = $converter;
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
    }

    /**
     * @inheritdoc
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        if (!$this->_options) {
            $statuses = $this->voucherStatusRepository->getList();

            $this->_options = [['label' => '', 'value' => '']];

            foreach ($statuses as $status) {
                $this->_options[] = [
                    'label' => $status->getStatusCode(),
                    'value' => $status->getId()
                ];
            }
        }

        return $this->_options;
    }
}
