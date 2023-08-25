<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Repositories\AssetRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\GroupRepositoryInterface;
use App\Repositories\VehicleMaintenanceEventRepositoryInterface;
use App\Repositories\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use function Symfony\Component\Translation\t;

/**
 * Class ArchiveService
 * @package App\Services
 */
class ArchiveService
{
    /**
     * CustomerRepositoryInterface depend injection.
     *
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CompanyRepositoryInterface depend injection.
     *
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    /**
     * VehicleRepositoryInterface depend injection.
     *
     * @var VehicleRepositoryInterface
     */
    private $vehicleRepository;

    /**
     * GroupRepositoryInterface depend injection.
     *
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * VehicleMaintenanceEventRepositoryInterface depend injection.
     *
     * @var VehicleMaintenanceEventRepositoryInterface
     */
    private $vehicleMaintenanceEventRepository;

    /**
     * AssetRepositoryInterface depend injection.
     *
     * @var AssetRepositoryInterface
     */
    private $assetRepository;

    /**
     * CategoryRepositoryInterface depend injection.
     *
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(
        CustomerRepositoryInterface                $customerRepository,
        CompanyRepositoryInterface                 $companyRepository,
        VehicleRepositoryInterface                 $vehicleRepository,
        GroupRepositoryInterface                   $groupRepository,
        VehicleMaintenanceEventRepositoryInterface $vehicleMaintenanceEventRepository,
        AssetRepositoryInterface                   $assetRepository,
        CategoryRepositoryInterface                $categoryRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->companyRepository = $companyRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->groupRepository = $groupRepository;
        $this->vehicleMaintenanceEventRepository = $vehicleMaintenanceEventRepository;
        $this->assetRepository = $assetRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return mixed
     */
    public function getArchivedCustomers()
    {
        return $this->customerRepository->allWhere(['*'], ['status' => 0]);
    }

    /**
     * @param array $where
     * @return Vehicle[]|Builder[]|Collection
     */
    public function getVehicles(array $where = [])
    {
        return $this->vehicleRepository->getVehicleMaleModel($where);
    }

    /**
     * @return mixed
     */
    public function getAllGroups()
    {
        return $this->groupRepository->allWhere(['id', 'name'], ['status' => 1]);
    }

    /**
     * @param $id
     * @return array
     */
    public function getGroups($id): array
    {
        return $this->groupRepository->getArchivedGroups($id);
    }

    /**
     * @param $id
     * @return void
     */
    public function unarchiveGroup($id)
    {
        $this->groupRepository->update(['status' => 1], $id);
    }

    /**
     * @return mixed
     */
    public function getVehicleMaintenanceEvents()
    {
        return $this->vehicleMaintenanceEventRepository->allWhere(['*'], ['status' => 0]);
    }

    /**
     * @param $data
     * @param $id
     * @return void
     */
    public function updateVehicleMaintenanceEvent($data, $id)
    {
        $this->vehicleMaintenanceEventRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleMaintenanceEvent($id)
    {
        return $this->vehicleMaintenanceEventRepository->find($id);
    }

    /**
     * @param $id
     * @return void
     */
    public function unarchiveVehicleMaintenanceEvent($id)
    {
        $this->vehicleMaintenanceEventRepository->update(['status' => 1], $id);
    }

    /**
     * @param $id
     * @return void
     */
    public function unarchiveCustomer($id)
    {
        $this->customerRepository->update(['status' => 1], $id);
    }

    /**
     * @param $data
     * @param $id
     * @return void
     */
    public function updateVehicle($data, $id)
    {
        $this->vehicleRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicle($id)
    {
        return $this->vehicleRepository->find($id);
    }

    /**
     * @param $id
     * @return void
     */
    public function unarchiveVehicle($id)
    {
        $this->vehicleRepository->update(['status' => 1], $id);
    }

    /**
     * @return mixed
     */
    public function getArchivedAssets()
    {
        return $this->assetRepository->allWhere(['*'], ['status' => 0]);
    }

    /**
     * @param $id
     * @return void
     */
    public function unarchiveAsset($id)
    {
        $this->assetRepository->update(['status' => 1], $id);
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categoryRepository->allWhere(['*'], ['status' => 0]);
    }

    /**
     * @param $id
     * @return void
     */
    public function unarchiveCategory($id)
    {
        $this->categoryRepository->update(['status' => 1], $id);
    }
}
