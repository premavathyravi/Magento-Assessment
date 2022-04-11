<?php

namespace Import\CustomerCreation\Profiles;

use Import\CustomerCreation\Helper\CsvParser;
use Import\CustomerCreation\Model\Data\Import;

class ProfileCsv extends Import implements ProfileInterface
{
    /**
     * @var CsvParser
     */
    protected $csvParser;

    /**
     * @param Import $import
     * @param CsvParser $csvParser
     */
    public function __construct(
        Import $import,
        CsvParser $csvParser
    ) {
        $this->import = $import;
        $this->csvParser = $csvParser;
    }


    /**
     * @param string $filepath
     * @param int $websiteId
     * @param int $storeId
     * @return mixed|void
     */
    public function getData(string $filepath, int $websiteId, int $storeId)
    {
        // read the csv header
        $header = $this->csvParser->readCsvHeader($filepath)->current();

        // read the csv file and skip the first (header) row
        $row = $this->csvParser->readCsvRows($filepath, $header);
        $row->next();

        while ($row->valid()) {
            $data = $row->current();
            $this->import->createCustomer($data, $websiteId, $storeId);
            $row->next();
        }
    }
}
