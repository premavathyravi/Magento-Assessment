<?php

namespace Import\CustomerCreation\Model;

use Exception;

use Magento\Framework\Filesystem\Io\File;
use Magento\Store\Model\StoreManagerInterface;
use Import\CustomerCreation\Profiles\Profilecsv;
use Import\CustomerCreation\Profiles\Profilejson;
use Symfony\Component\Console\Output\OutputInterface;

class Customer
{
    private $file;
    private $storeManagerInterface;
    private $output;
    private $profilecsv;
    private $profilejson;

    public function __construct(
        File $file,
        StoreManagerInterface $storeManagerInterface,
        Profilecsv $profilecsv,
        Profilejson $profilejson
    ) {
        $this->file = $file;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->profilecsv = $profilecsv;
        $this->profilejson = $profilejson;
    }

    public function install(string $fixture, OutputInterface $output, string $extension): void
    {
        $this->output = $output;

        // get store and website ID
        $store = $this->storeManagerInterface->getStore();
        $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
        $storeId = (int) $store->getId();

        if ($extension == 'csv') {
            $this->profilecsv->getData($fixture, $websiteId, $storeId);
        }
        if ($extension == 'json') {
            $this->profilejson->getData($fixture, $websiteId, $storeId);
        }
    }
}
