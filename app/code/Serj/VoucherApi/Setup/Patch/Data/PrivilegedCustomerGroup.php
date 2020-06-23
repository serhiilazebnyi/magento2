<?php

namespace Serj\VoucherApi\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Customer\Model\GroupFactory;

class PrivilegedCustomerGroup implements DataPatchInterface, PatchVersionInterface
{
    private $groupFactory;

    public function __construct(
        GroupFactory $groupFactory
    ) {
        $this->groupFactory = $groupFactory;
    }

    public function apply()
    {
        $group = $this->groupFactory->create();
        $group->setCode('Privileged Customers')
            ->setTaxClassId(3)
            ->save();

    }

    public static function getDependencies()

    {
         return [];
    }

    public static function getVersion()
    {
        return '2.0.0';
    }

    public function getAliases()
    {
         return [];
      }
    }
