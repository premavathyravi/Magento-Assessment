<?php

namespace Import\CustomerCreation\Model;

use Exception;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Io\File;
use Magento\Store\Model\StoreManagerInterface;
use Import\CustomerCreation\Profiles\ProfileCsv;
use Import\CustomerCreation\Profiles\ProfileJson;
use Symfony\Component\Console\Output\OutputInterface;

class Customer
{
    /**
     * @var File
     */
    private $file;
    /**
     * @var StoreManagerInterface
     */
    private $storeManagerInterface;

    /**
     * @var ProfileCsv
     */
    private $profilecsv;
    /**
     * @var ProfileJson
     */
    private $profilejson;

    /**
     * @param File $file
     * @param StoreManagerInterface $storeManagerInterface
     * @param ProfileCsv $profilecsv
     * @param ProfileJson $profilejson
     */
    public function __construct(
        File $file,
        StoreManagerInterface $storeManagerInterface,
        ProfileCsv $profilecsv,
        ProfileJson $profilejson
    ) {
        $this->file = $file;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->profilecsv = $profilecsv;
        $this->profilejson = $profilejson;
    }


    /**
     * @param string $filepath
     * @param OutputInterface $output
     * @param string $extension
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function fileProcessor(string $filepath, OutputInterface $output, string $extension): void
    {
        try {
            // get store and website ID
            $store = $this->storeManagerInterface->getStore();
            $websiteId = (int) $this->storeManagerInterface->getWebsite()->getId();
            $storeId = (int) $store->getId();

            if ($extension == 'csv') {
                $this->profilecsv->getData($filepath, $websiteId, $storeId);
            }
            if ($extension == 'json') {
                $this->profilejson->getData($filepath, $websiteId, $storeId);
            }
        } catch (FileSystemException $e) {
            $msg = $e->getMessage();
            $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
        }
    }
}
