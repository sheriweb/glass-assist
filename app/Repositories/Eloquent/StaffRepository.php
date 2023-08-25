<?php

namespace App\Repositories\Eloquent;

use App\Models\Staff;
use App\Repositories\StaffRepositoryInterface;

/**
 * Class StaffRepository
 * @package App\Repositories
 */
class StaffRepository extends BaseRepository implements StaffRepositoryInterface
{
    /**
     * @param Staff $staff
     */
    public function __construct(Staff $staff)
    {
        parent::__construct($staff);
    }
}
