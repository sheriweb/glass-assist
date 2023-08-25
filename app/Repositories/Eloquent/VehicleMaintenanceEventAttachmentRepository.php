<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleMaintenanceEventAttachment;
use App\Repositories\VehicleMaintenanceEventAttachmentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleMaintenanceEventAttachmentRepository
 * @package App\Repositories
 */
class VehicleMaintenanceEventAttachmentRepository extends BaseRepository implements VehicleMaintenanceEventAttachmentRepositoryInterface
{
    /**
     * @param VehicleMaintenanceEventAttachment $vehicleMaintenanceEventAttachment
     */
    public function __construct(VehicleMaintenanceEventAttachment $vehicleMaintenanceEventAttachment)
    {
        parent::__construct($vehicleMaintenanceEventAttachment);
    }

    /**
     * @param $id
     * @return Builder[]|Collection|VehicleMaintenanceEventAttachment[]
     */
    public function findAttachment($id)
    {
        return VehicleMaintenanceEventAttachment::query()
            ->where('vehicle_maintenance_event_id', '=', $id)
            ->get();
    }
}
