<?php

namespace App\Repositories;

use App\Models\VehicleMaintenanceEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @Class UserRepositoryInterface
 * @package App\Repositories
 */
interface VehicleMaintenanceEventRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $first
     * @param $end
     * @return Builder[]|Collection
     */
    public function getDue($first, $end);

    /**
     * @param $date
     * @return VehicleMaintenanceEvent[]|Builder[]|Collection
     */
    public function getOverDue($date);

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleEventById($id);
}
