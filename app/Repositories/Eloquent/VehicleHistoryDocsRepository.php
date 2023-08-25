<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleHistoryDocs;
use App\Repositories\VehicleHistoryDocsRepositoryInterface;

/**
 * Class VehicleHistoryDocsRepository
 * @package App\Repositories
 */
class VehicleHistoryDocsRepository extends BaseRepository implements VehicleHistoryDocsRepositoryInterface
{
    /**
     * @param VehicleHistoryDocs $vehicleHistoryDocs
     */
    public function __construct(VehicleHistoryDocs $vehicleHistoryDocs)
    {
        parent::__construct($vehicleHistoryDocs);
    }
}
