<?php

namespace App\Services;

use App\Repositories\CarMakeRepositoryInterface;
use App\Repositories\CarModelRepositoryInterface;
use App\Repositories\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class VehicleService
 * @package App\Services
 */
class VehicleHistoryService
{
    /**
     * VehicleRepositoryInterface depend injection.
     *
     * @var VehicleRepositoryInterface
     */
    private $vehicleRepository;

    /**
     * CarMakeRepositoryInterface depend injection.
     *
     * @var CarMakeRepositoryInterface
     */
    private $carMakeRepository;

    /**
     * CarModelRepositoryInterface depend injection.
     *
     * @var CarModelRepositoryInterface
     */
    private $carModelRepository;

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        CarMakeRepositoryInterface $carMakeRepository,
        CarModelRepositoryInterface $carModelRepository
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->carMakeRepository = $carMakeRepository;
        $this->carModelRepository = $carModelRepository;
    }


}
