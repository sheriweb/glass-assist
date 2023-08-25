<?php

namespace App\Repositories\Eloquent;

use App\Models\CarModel;
use App\Repositories\CarModelRepositoryInterface;

/**
 * Class CarModelRepository
 * @package App\Repositories
 */
class CarModelRepository extends BaseRepository implements CarModelRepositoryInterface
{
    /**
     * @param CarModel $carModel
     */
    public function __construct(CarModel $carModel)
    {
        parent::__construct($carModel);
    }
}
