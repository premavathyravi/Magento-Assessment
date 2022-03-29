<?php

namespace Import\CustomerCreation\Profiles;

use Generator;
use Import\CustomerCreation\Model\Data\Import;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Serialize\SerializerInterface;
use Import\CustomerCreation\Profiles\ProfileInterface;
use Magento\Framework\Exception\InvalidArgumentException;

class Profilejson extends Import implements ProfileInterface
{
    public function __construct(
        Import $import,
        File $file,
        SerializerInterface $serializer
    ) {
        $this->import = $import;
        $this->serializer = $serializer;
        $this->file = $file;
    }

    public function getData(string $fixture, int $websiteId, int $storeId)
    {
        $str = $this->file->fileGetContents($fixture);

        $json = $this->serializer->unserialize($str, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(__('Unable to unserialize json file.'));
        }
        foreach ($json as $key => $value) {
            foreach ($value as $key => $val) {
                $data[$key] = $val;
            }
            $this->import->createCustomer($data, $websiteId, $storeId);
        }
    }
}
