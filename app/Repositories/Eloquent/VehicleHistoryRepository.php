<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleHistory;
use App\Repositories\VehicleHistoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class BookingRepository
 * @package App\Repositories
 */
class VehicleHistoryRepository extends BaseRepository implements VehicleHistoryRepositoryInterface
{
    /**
     * @param VehicleHistory $vehicleHistory
     */
    public function __construct(VehicleHistory $vehicleHistory)
    {
        parent::__construct($vehicleHistory);
    }

    /**
     * @inheritDoc
     */
    public function getVehicleHistoryById($id)
    {
        return VehicleHistory::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findByCalendarDateTime($type, $start, $end)
    {
        $start = date('Y-m-d 00:00:00', strtotime($start));
        $end = date('Y-m-d 23:59:59', strtotime($end));

        return VehicleHistory::whereCalendar($type)
            ->where('datetime', '>=', $start)
            ->where('datetime', '<=', $end)
            ->where('type', 'jobcard')
            ->whereIn('status', [1, 2, 3, 4, 5, 6, 7, 8, 9])
            ->orderByRaw("FIELD(status,6,1,2,4,5,3), DATE(datetime) desc, TIME(datetime)")
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function getAllByDate($start, $end)
    {
        return VehicleHistory::query()
            ->whereBetween('datetime', [$start, $end])
            ->get();
    }

    /**
     * @param $id
     * @return VehicleHistory|Builder|Model|object|null
     */
    public function getVehicleHistory($id)
    {
        return VehicleHistory::query()->where('id', '=', $id)
            ->with('customer', 'company', 'jobCardItems', 'addedBy', 'updatedBy', 'technicianOne', 'vehicle')
            ->first();
    }

    /**
     * @param $date
     * @return VehicleHistory[]|Builder[]|Collection
     */
    public function technicianHistory($date)
    {
        return VehicleHistory::query()
            ->whereDate('datetime', '=', $date)
            ->withCount('user')
            ->get();
    }

    public function getTechnicianBookingsByDate($technicianId, $date)
    {
        return VehicleHistory::query()
            ->where('technician', $technicianId)
            ->whereDate('datetime',  $date)
            ->get();
    }

    public function updateTechnicianVehicleHistory($request)
    {
        $vehicleHistory = VehicleHistory::find($request->vehicle_history_id);
        if ($vehicleHistory) {
            if (isset($request->pre_job_complete)) {
                $vehicleHistory->update([
                    'pre_job_complete' => 1,
                    'status' => VehicleHistory::statusId('in_progress'),
                    'pre_check_notes' => $request->pre_check_notes,
                    'pre_c_name' => $request->pre_c_name,
                ]);
            }
            if (isset($request->job_complete)) {
                $vehicleHistory->update([
                    'job_complete' => 1,
                    'status' => VehicleHistory::statusId('job_completed'),
                    'c_name' => $request->c_name,
                    'payment_type' => $request->payment_type,
                    's_date' => Carbon::now()->toDateTimeString(),
                    's_name' => auth()->user()->first_name,
                ]);
            }
            if (isset($request->job_not_completed)) {
                $vehicleHistory->update([
                    'job_not_completed' => 1,
                    'status' => VehicleHistory::statusId('cancelled'),
                    'technician_note' => $request->technician_note,
                    'technician_statement' => $request->technician_statement,

                ]);
            }
            return response()->json([
                'status' => 200,
                'vehicle_history_id' => $vehicleHistory->id,
                'message' => '',
                'info_type' => 'success'
            ]);
        }
    }
}
