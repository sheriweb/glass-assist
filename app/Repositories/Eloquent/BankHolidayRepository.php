<?php

namespace App\Repositories\Eloquent;

use App\Models\BankHoliday;
use App\Repositories\BankHolidayRepositoryInterface;

/**
 * Class BankHolidayRepository
 * @package App\Repositories
 */
class BankHolidayRepository extends BaseRepository implements BankHolidayRepositoryInterface
{
    /**
     * @param BankHoliday $bankHoliday
     */
    public function __construct(BankHoliday $bankHoliday)
    {
        parent::__construct($bankHoliday);
    }
}
