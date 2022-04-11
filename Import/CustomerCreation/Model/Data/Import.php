<?php

namespace Import\CustomerCreation\Model\Data;

use Import\CustomerCreation\Model\Import\CustomerImport;

class Import extends CustomerImport
{

    /**
     * @var CustomerImport
     */
    private $customerImport;

    /**
     * @param CustomerImport $customerImport
     */
    public function __construct(
        CustomerImport $customerImport
    ) {
        $this->customerImport = $customerImport;
    }

    /**
     * @param array $data
     * @param int $websiteId
     * @param int $storeId
     * @return void
     */
    public function createCustomer(array $data, int $websiteId, int $storeId): void
    {
        try {
            // collect the customer data
            $customerData = [
                'email'         => $data['emailaddress'],
                '_website'      => 'base',
                '_store'        => 'default',
                'confirmation'  => null,
                'dob'           => null,
                'firstname'     => $data['fname'],
                'gender'        => null,
                'group_id'      => null,
                'lastname'      => $data['lname'],
                'middlename'    => null,
                'password_hash' => null,
                'prefix'        => null,
                'store_id'      => $storeId,
                'website_id'    => $websiteId,
                'password'      => null,
                'disable_auto_group_change' => 0,
                'some_custom_attribute'     => 'some_custom_attribute_value'
            ];

            // save the customer data
            $this->customerImport->importCustomerData($customerData);

        } catch (Exception $e) {
            $this->output->writeln(
                '<error>'. $e->getMessage() .'</error>',
                OutputInterface::OUTPUT_NORMAL
            );
        }
    }
}
