<?php
namespace Import\CustomerCreation\Profiles;

interface ProfileInterface
{
    /**
     * @param string $fixture
     * @param int $websiteId
     * @param int $storeId
     * @return mixed
     */
    public function getData(string $fixture, int $websiteId, int $storeId);
}
