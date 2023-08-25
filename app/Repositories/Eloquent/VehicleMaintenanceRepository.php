<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleMaintenance;
use App\Repositories\VehicleMaintenanceRepositoryInterface;

/**
 * Class VehicleMaintenanceRepository
 * @package App\Repositories
 */
class VehicleMaintenanceRepository extends BaseRepository implements VehicleMaintenanceRepositoryInterface
{
    /**
     * @param VehicleMaintenance $vehicleMaintenance
     */
    public function __construct(VehicleMaintenance $vehicleMaintenance)
    {
        parent::__construct($vehicleMaintenance);
    }

    /**
     * @inheritDoc
     */
    public function getDue($first, $end)
    {
        return $this->model::query()
            ->whereBetween('mot_date', [$first, $end])
            ->orWhereBetween('service_date', [$first, $end])
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getOverDue($date)
    {
        return VehicleMaintenance::query()
            ->where('mot_date', '<', $date)
            ->orWhere('service_date', '<', $date)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getAllStatus()
    {
        return VehicleMaintenance::query()
            ->where('status', '=', 1)
            ->get();
    }
}
