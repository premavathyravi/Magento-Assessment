<?php

namespace Import\CustomerCreation\Helper;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\DriverInterface;

class CsvParser
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(
        DriverInterface $driver
    ) {
        $this->driver = $driver;
    }

    /**
     * @param string $file
     * @param array $header
     * @return \Generator
     * @throws FileSystemException
     */
    public function readCsvRows(string $file, array $header)
    {
        $handle = $this->driver->fileOpen($file, 'rb');

        while (!feof($handle)) {
            $data = [];
            $rowData = fgetcsv($handle);
            if ($rowData) {
                foreach ($rowData as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                yield $data;
            }
        }
        $this->driver->fileClose($handle);
    }


    /**
     * @param string $file
     * @return \Generator
     * @throws FileSystemException
     */
    public function readCsvHeader(string $file)
    {
        $handle = $this->driver->fileOpen($file, 'rb');

        while (!feof($handle)) {
            yield fgetcsv($handle);
        }
        $this->driver->fileClose($handle);
    }
}
