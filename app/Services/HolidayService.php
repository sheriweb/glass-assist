<?php

namespace App\Services;

use App\Repositories\BankHolidayRepositoryInterface;
use App\Repositories\HolidayRepositoryInterface;

/**
 * Class HolidayService
 * @package App\Services
 */
class HolidayService
{
    /**
     * CategoryRepositoryInterface depend injection.
     *
     * @var HolidayRepositoryInterface
     */
    private $holidayRepository;

    /**
     * AssetRepositoryInterface depend injection.
     *
     * @var BankHolidayRepositoryInterface
     */
    private $bankHolidayRepository;

    public function __construct(
        HolidayRepositoryInterface $holidayRepository,
        BankHolidayRepositoryInterface $bankHolidayRepository
    ) {
        $this->holidayRepository = $holidayRepository;
        $this->bankHolidayRepository = $bankHolidayRepository;
    }

    public function getStaffHolidays($data)
    {
        return $this->holidayRepository->getHolidaysFilter($data);
    }

    public function getBankHolidays($data)
    {
        $data['date_from'] = date('Y-m-d 00:00:00', strtotime($data['date_from']));
        $data['date_to'] = date('Y-m-d 23:59:59', strtotime($data['date_to']));

        return $this->bankHolidayRepository->allWhere(
            ['*'],
            [['date_from', '>=', $data['date_from']], ['date_to', '<=', $data['date_to']]]
        );
    }
}
