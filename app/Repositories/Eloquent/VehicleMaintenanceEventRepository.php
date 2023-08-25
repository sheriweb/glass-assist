<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleMaintenanceEvent;
use App\Repositories\VehicleMaintenanceEventRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleMaintenanceEventRepository
 * @package App\Repositories
 */
class VehicleMaintenanceEventRepository extends BaseRepository implements VehicleMaintenanceEventRepositoryInterface
{
    /**
     * @param VehicleMaintenanceEvent $vehicleMaintenanceEvent
     */
    public function __construct(VehicleMaintenanceEvent $vehicleMaintenanceEvent)
    {
        parent::__construct($vehicleMaintenanceEvent);
    }

    /**
     * @inheritDoc
     */
    public function getDue($first, $end)
    {
        return $this->model::query()
            ->whereBetween('start_date', [$first, $end])
            ->where('status', '=', 1)
            ->where('event_completed', '=', NULL)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getOverDue($date)
    {
        return VehicleMaintenanceEvent::query()
            ->where('start_date', '<', $date)
            ->where('status', '=', 1)
            ->Where('event_completed', '=', NULL)
            ->get();
    }

    /**
     * @param $id
     * @return Builder|Model|object|VehicleMaintenanceEvent|null
     */
    public function getVehicleEventById($id)
    {
     return VehicleMaintenanceEvent::query()
         ->where('id','=',$id)
         ->first();
    }
}
