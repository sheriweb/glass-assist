<?php

namespace App\Repositories\Eloquent;

use App\Models\CarMake;
use App\Repositories\CarMakeRepositoryInterface;

/**
 * Class CarMakeRepository
 * @package App\Repositories
 */
class CarMakeRepository extends BaseRepository implements CarMakeRepositoryInterface
{
    /**
     * @param CarMake $carMake
     */
    public function __construct(CarMake $carMake)
    {
        parent::__construct($carMake);
    }
}
