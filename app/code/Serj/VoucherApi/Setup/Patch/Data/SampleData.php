<?php

namespace Serj\VoucherApi\Setup\Patch\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\CustomerFactory;
use Serj\VoucherApi\Model\VoucherStatusFactory;
use Serj\VoucherApi\Model\VoucherFactory;

class SampleData implements DataPatchInterface, PatchVersionInterface
{
    private $moduleDataSetup;
    private $customerFactory;
    private $voucherStatusFactory;
    private $voucherFactory;
    private $storeManager;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StoreManagerInterface $storeManager,
        CustomerFactory $customerFactory,
        VoucherStatusFactory $voucherStatusFactory,
        VoucherFactory $voucherFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->voucherStatusFactory = $voucherStatusFactory;
        $this->voucherFactory = $voucherFactory;
    }

    public function apply()
    {
        $websiteId  = $this->storeManager->getWebsite()->getWebsiteId();

        $customerData = [
            [
                'website_id'    => $websiteId,
                'email'         => 'ironman@avengers.com',
                'firstname'     => 'Tony',
                'lastname'      => 'Stark',
                'password'      => 'password'
            ],
            [
                'website_id'    => $websiteId,
                'email'         => 'captain@avengers.com',
                'firstname'     => 'Steven',
                'lastname'      => 'Rogers',
                'password'      => 'password'
            ],
            [
                'website_id'    => $websiteId,
                'email'         => 'widow@mail.com',
                'firstname'     => 'Natasha',
                'lastname'      => 'Romanoff',
                'password'      => 'password'
            ],
        ];

        foreach ($customerData as $data) {
            $customer = $this->customerFactory->create();
            $customer->setData($data);
            $customer->save();
            $customerId[] = $customer->getId();
        }

        $voucherStatusData = [
            ['status_code' => 'ACTIVE'],
            ['status_code' => 'EXPIRED'],
            ['status_code' => 'APPLIED'],
        ];

        foreach($voucherStatusData as $data) {
            $voucherStatus = $this->voucherStatusFactory->create();
            $voucherStatus->setData($data);
            $voucherStatus->save();
            $voucherStatusId[] = $voucherStatus->getId();
        }

        for ($i=0; $i < 20; $i++) {
            $data = [
                'customer_id'   => $customerId[mt_rand(0, count($customerId) - 1)],
                'status_id'     => $voucherStatusId[mt_rand(0, count($voucherStatusId) - 1)],
                'voucher_code'  => md5(mt_rand(0, 9000)),
            ];

            $voucher = $this->voucherFactory->create();
            $voucher->setData($data);
            $voucher->save();
        }
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
