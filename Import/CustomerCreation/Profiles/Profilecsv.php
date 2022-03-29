<?php

namespace Import\CustomerCreation\Profiles;

use Generator;
use Import\CustomerCreation\Model\Data\Import;
use Magento\Framework\Filesystem\DriverInterface;
use Import\CustomerCreation\Profiles\ProfileInterface;

class Profilecsv extends Import implements ProfileInterface
{
    public function __construct(
        Import $import,
        DriverInterface $driver
    ) {
        $this->import = $import;
        $this->driver = $driver;
    }

    public function getData(string $fixture, int $websiteId, int $storeId)
    {
        // read the csv header
        $header = $this->readCsvHeader($fixture)->current();

        // read the csv file and skip the first (header) row
        $row = $this->readCsvRows($fixture, $header);
        $row->next();

        // while the generator is open, read current row data, create a customer and resume the generator
        while ($row->valid()) {
            $data = $row->current();
            $this->import->createCustomer($data, $websiteId, $storeId);
            $row->next();
        }
    }
    private function readCsvRows(string $file, array $header): ?Generator
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
    private function readCsvHeader(string $file): ?Generator
    {
        $handle = $this->driver->fileOpen($file, 'rb');

        while (!feof($handle)) {
            yield fgetcsv($handle);
        }

        $this->driver->fileClose($handle);
    }
}
