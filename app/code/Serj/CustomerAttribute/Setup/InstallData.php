<?php

namespace Serj\CustomerAttribute\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class InstallData implements InstallDataInterface
{
    protected $customerSetupFactory;

    private $attributeSetFactory;

    public function __construct(
        AttributeSetFactory $attributeSetFactory,
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->attributeSetFactory = $attributeSetFactory;
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'custom_customer_text_attribute',
            [
                'type' => 'text',
                'label' => 'Custom Customer Text Attribute',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'source' => '',
                'backend' => '',
                'user_defined' => false,
                'is_user_defined' => false,
                'sort_order' => 1000,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => false,
                'is_searchable_in_grid' => false,
                'position' => 1000,
                'default' => 0,
                'system' => 0,
            ]
        );

         $attribute = $customerSetup->getEavConfig()
            ->getAttribute(Customer::ENTITY, 'custom_customer_text_attribute')
            ->addData([
                 'attribute_set_id' => $attributeSetId,
                 'attribute_group_id' => $attributeGroupId,
                 'used_in_forms' => ['adminhtml_customer'],
          ]);

         $attribute->save();
     }
 }
