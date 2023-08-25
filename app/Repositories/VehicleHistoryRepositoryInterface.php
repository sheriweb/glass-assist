<?php

namespace App\Repositories;

use App\Models\VehicleHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @Class BookingRepositoryInterface
 * @package App\Repositories
 */
interface VehicleHistoryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleHistoryById($id);

    /**
     * @param $type
     * @param $start
     * @param $end
     * @return VehicleHistory[]|Builder[]|Collection
     */
    public function findByCalendarDateTime($type, $start, $end);

    /**
     * @param $start
     * @param $end
     * @return Builder[]|Collection|VehicleHistory[]
     */
    public function getAllByDate($start, $end);

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleHistory($id);

    /**
     * @param $technicianId
     * @return mixed
     */
    public function getTechnicianBookingsByDate($technicianId, $date);

    /**
     * @param $request
     * @return mixed
     */
    public function updateTechnicianVehicleHistory($request);


}
