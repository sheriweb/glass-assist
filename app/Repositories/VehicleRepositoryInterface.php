<?php

namespace App\Repositories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @Class VehicleRepositoryInterface
 * @package App\Repositories
 */
interface VehicleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $where
     * @return Vehicle[]|Builder[]|Collection
     */
    public function getVehicleMaleModel(array $where = []);
}
