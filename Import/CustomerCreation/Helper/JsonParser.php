<?php

namespace Import\CustomerCreation\Helper;

use Magento\Framework\Exception\InvalidArgumentException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Serialize\SerializerInterface;

class JsonParser
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var File
     */
    protected $file;


    /**
     * @param File $file
     * @param SerializerInterface $serializer
     */
    public function __construct(
        File $file,
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
        $this->file = $file;
    }

    /**
     * @param string $filepath
     * @return array|void
     * @throws InvalidArgumentException
     */
    public function readJson(string $filepath)
    {
        $str = $this->file->fileGetContents($filepath);
        $json = $this->serializer->unserialize($str, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(__('Unable to unserialize json file.'));
        }
        foreach ($json as $value) {
            foreach ($value as $key => $val) {
                $data[$key] = $val;
            }
            $jsonarr[] = $data;
        }
        return $jsonarr;
    }
}
