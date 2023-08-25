<?php

namespace App\Repositories\Eloquent;

use App\Models\VehicleHistoryInvoice;
use App\Repositories\VehicleHistoryInvoiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class VehicleHistoryInvoiceRepository
 * @package App\Repositories
 */
class VehicleHistoryInvoiceRepository extends BaseRepository implements VehicleHistoryInvoiceRepositoryInterface
{
    /**
     * @param VehicleHistoryInvoice $vehicleHistoryInvoice
     */
    public function __construct(VehicleHistoryInvoice $vehicleHistoryInvoice)
    {
        parent::__construct($vehicleHistoryInvoice);
    }

    /**
     * @inheritDoc
     */
    public function getAllFilter($start, $end): LengthAwarePaginator
    {
        return VehicleHistoryInvoice::query()
            ->whereBetween('datetime', [$start, $end])
            ->where('status', '!=', 0)
            ->paginate(50);
    }
}
