<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @Class VehicleHistoryInvoiceRepositoryInterface
 * @package App\Repositories
 */
interface VehicleHistoryInvoiceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $start
     * @param $end
     * @return LengthAwarePaginator
     */
    public function getAllFilter($start, $end): LengthAwarePaginator;
}
