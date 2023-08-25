<?php

namespace App\Repositories\Eloquent;

use App\Models\Holiday;
use App\Repositories\HolidayRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class HolidayRepository
 * @package App\Repositories
 */
class HolidayRepository extends BaseRepository implements HolidayRepositoryInterface
{
    /**
     * @param Holiday $holiday
     */
    public function __construct(Holiday $holiday)
    {
        parent::__construct($holiday);
    }

    /**
     * @inheritDoc
     */
    public function getHolidaysFilter(array $data)
    {
        $dql = Holiday::query();

        if (isset($data['year'])) {
            $year = $data['year'];
            $nextYear = Carbon::create($year)->addYear();

            $dql->whereBetween('date_from', [
                Carbon::create($year)->toDateTimeString(),
                $nextYear->toDateTimeString()
            ]);
        }

        if (isset($data['staff_id']) && $data['staff_id'] !== '---') {
            $dql->where('staff_id', '=', $data['staff_id']);
        }

        if (isset($data['type']) && $data['type'] !== '---') {
            $dql->where('type', '=', $data['type']);
        }

        if (isset($data['date_from'])) {
            $data['date_from'] = date('Y-m-d 00:00:00', strtotime($data['date_from']));
            $dql->where('date_from', '>=', $data['date_from']);
        }

        if (isset($data['date_to'])) {
            $data['date_to'] = date('Y-m-d 23:59:59', strtotime($data['date_to']));
            $dql->where('date_to', '<=', $data['date_to']);
        }

        return $dql
            ->where('holidays.status', '=', 1)
            ->leftJoin('staff', 'holidays.staff_id', '=', 'staff.id')
            ->select("holidays.*", DB::raw("CONCAT(staff.first_name,' ',staff.surname) AS name"))
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function get()
    {
        return Holiday::query()
            ->leftJoin('staff', 'holidays.staff_id', '=', 'staff.id')
            ->select("holidays.*", DB::raw("CONCAT(staff.first_name,' ',staff.surname) AS name"))
            ->get();
    }
}
