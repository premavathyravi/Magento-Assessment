<?php
namespace Import\CustomerCreation\Profiles;

interface ProfileInterface
{
    /**
     * @param string $filepath
     * @param int $websiteId
     * @param int $storeId
     * @return mixed
     */
    public function getData(string $filepath, int $websiteId, int $storeId);
}
