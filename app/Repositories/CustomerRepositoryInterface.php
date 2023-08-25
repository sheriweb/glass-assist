<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

/**
 * @Class CustomerRepositoryInterface
 * @package App\Repositories
 */
interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $customerId
     * @param $vehicleId
     * @param $userId
     * @return void
     */
    public function linkVehicle($customerId, $vehicleId, $userId);

    /**
     * @param $customerId
     * @param $vehicleId
     * @return Collection
     */
    public function alreadyLinked($customerId, $vehicleId): Collection;

    /**
     * @param $customerId
     * @param $groupId
     * @param $userId
     * @return void
     */
    public function setCustomerGroup($customerId, $groupId, $userId);
}
