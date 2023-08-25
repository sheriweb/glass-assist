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
class VehicleService
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
        VehicleRepositoryInterface  $vehicleRepository,
        CarMakeRepositoryInterface  $carMakeRepository,
        CarModelRepositoryInterface $carModelRepository
    )
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->carMakeRepository = $carMakeRepository;
        $this->carModelRepository = $carModelRepository;
    }

    /**
     * @return mixed
     */
    public function getVehicleByField($field, array $data)
    {
        return $this->vehicleRepository->whereIn($field, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleById($id)
    {
        return $this->vehicleRepository->find($id);
    }

    /**
     * @param $searchValue
     * @return int
     */
    public function getVehiclesCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->vehicleRepository->whereLikeCount('name', $searchValue);
        }

        return $this->vehicleRepository->counts();
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder[]|Collection
     */
    public function getVehiclesPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    )
    {
        return $this->vehicleRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'reg_no'
        );
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createVehicle(array $data)
    {
        return $this->vehicleRepository->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function updateCustomer($id, array $data)
    {
        $this->vehicleRepository->update($data, $id);
    }

    /**
     * @param array $fields
     * @return mixed
     */
    public function getCarMakes(array $fields = ['*'])
    {
        return $this->carMakeRepository->all($fields);
    }

    /**
     * @param array $fields
     * @param int $makeId
     * @return mixed
     */
    public function getCarModelsByMakeId(array $fields = ['*'], int $makeId)
    {
        return $this->carModelRepository->all($fields, ['make_id' => $makeId]);
    }

    /**
     * @param $field
     * @param array $data
     * @return mixed
     */
    public function getCarModelsByField($field, array $data)
    {
        return $this->carModelRepository->whereIn($field, $data);
    }

    public function updateVehicle(array $attribute, $id)
    {
        return  $this->vehicleRepository->update($attribute, $id);
    }

    public function dvlaLookupByVehicleReg($vehicleRegNo)
    {
        return  $this->vehicleRepository->getDvlaLookupByVehicleReg($vehicleRegNo);
    }
}
