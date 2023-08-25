<?php

namespace App\Repositories;

use App\Models\VehicleMaintenance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @Class UserRepositoryInterface
 * @package App\Repositories
 */
interface VehicleMaintenanceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $first
     * @param $end
     * @return Builder[]|Collection
     */
    public function getDue($first, $end);

    /**
     * @param $date
     * @return VehicleMaintenance[]|Builder[]|Collection
     */
    public function getOverDue($date);

    /**
     * @return VehicleMaintenance|Builder|Collection
     */
    public function getAllStatus();
}
