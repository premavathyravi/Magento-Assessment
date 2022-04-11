<?php

namespace Import\CustomerCreation\Profiles;

use Import\CustomerCreation\Helper\JsonParser;
use Import\CustomerCreation\Model\Data\Import;

class ProfileJson extends Import implements ProfileInterface
{
    /**
     * @var JsonParser
     */
    protected $jsonParser;


    /**
     * @param Import $import
     * @param JsonParser $jsonParser
     */
    public function __construct(
        Import $import,
        JsonParser $jsonParser
    ) {
        $this->import = $import;
        $this->jsonParser = $jsonParser;
    }


    /**
     * @param string $filepath
     * @param int $websiteId
     * @param int $storeId
     * @return mixed|void
     * @throws \Magento\Framework\Exception\InvalidArgumentException
     */
    public function getData(string $filepath, int $websiteId, int $storeId)
    {
        $jsonarr = $this->jsonParser->readJson($filepath);
        foreach ($jsonarr as $data) {
            $this->import->createCustomer($data, $websiteId, $storeId);
        }
    }
}
