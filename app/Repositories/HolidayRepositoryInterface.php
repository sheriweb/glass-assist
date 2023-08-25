<?php

namespace App\Repositories;

use App\Models\Holiday;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @Class HolidayRepositoryInterface
 * @package App\Repositories
 */
interface HolidayRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $data
     * @return Holiday[]|LengthAwarePaginator|Builder[]|Collection
     */
    public function getHolidaysFilter(array $data);

    /**
     * @return Holiday|Builder|Collection
     */
    public function get();
}
