<?php

namespace App\Services;

use App\Models\Holiday;
use App\Models\User;
use App\Models\VehicleMaintenance;
use App\Repositories\BankHolidayRepositoryInterface;
use App\Repositories\CarMakeRepositoryInterface;
use App\Repositories\CarModelRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\CourtesyCarRepositoryInterface;
use App\Repositories\GlassSupplierRepositoryInterface;
use App\Repositories\HolidayRepositoryInterface;
use App\Repositories\ItemRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\SettingRepositoryInterface;
use App\Repositories\StaffRepositoryInterface;
use App\Repositories\SubContractorRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VehicleHistoryInvoiceRepositoryInterface;
use App\Repositories\VehicleMaintenanceEventRepositoryInterface;
use App\Repositories\VehicleMaintenanceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AdminService
 * @package App\Services
 */
class AdminService
{
    /**
     * UserRepositoryInterface depend injection.
     *
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * CourtesyCarRepositoryInterface depend injection.
     *
     * @var CourtesyCarRepositoryInterface
     */
    private $courtesyCarRepository;

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

    /**
     * StaffRepositoryInterface depend injection.
     *
     * @var StaffRepositoryInterface
     */
    private $staffRepository;

    /**
     * VehicleMaintenanceRepositoryInterface depend injection.
     *
     * @var VehicleMaintenanceRepositoryInterface
     */
    private $vehicleMaintenanceRepository;

    /**
     * CompanyRepositoryInterface depend injection.
     *
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    /**
     * GlassSupplierRepositoryInterface depend injection.
     *
     * @var GlassSupplierRepositoryInterface
     */
    private $glassSupplierRepository;

    /**
     * SubContractorRepositoryInterface depend injection.
     *
     * @var SubContractorRepositoryInterface
     */
    private $subContractorRepository;

    /**
     * VehicleMaintenanceEventRepositoryInterface depend injection.
     *
     * @var VehicleMaintenanceEventRepositoryInterface
     */
    private $vehicleMaintenanceEventRepository;

    /**
     * BankHolidayRepositoryInterface depend injection.
     *
     * @var BankHolidayRepositoryInterface
     */
    private $bankHolidayRepository;

    /**
     * HolidayRepositoryInterface depend injection.
     *
     * @var HolidayRepositoryInterface
     */
    private $holidayRepository;

    /**
     * OrderRepositoryInterface depend injection.
     *
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * VehicleHistoryInvoiceRepositoryInterface depend injection.
     *
     * @var VehicleHistoryInvoiceRepositoryInterface
     */
    private $vehicleHistoryInvoiceRepository;

    /**
     * SettingRepositoryInterface depend injection.
     *
     * @var SettingRepositoryInterface
     */
    private $settingRepository;

    /**
     * ItemRepositoryInterface depend injection.
     *
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    public function __construct(
        UserRepositoryInterface                    $userRepository,
        CourtesyCarRepositoryInterface             $courtesyCarRepository,
        CarMakeRepositoryInterface                 $carMakeRepository,
        CarModelRepositoryInterface                $carModelRepository,
        StaffRepositoryInterface                   $staffRepository,
        VehicleMaintenanceRepositoryInterface      $vehicleMaintenanceRepository,
        VehicleMaintenanceEventRepositoryInterface $vehicleMaintenanceEventRepository,
        CompanyRepositoryInterface                 $companyRepository,
        GlassSupplierRepositoryInterface           $glassSupplierRepository,
        SubContractorRepositoryInterface           $subContractorRepository,
        BankHolidayRepositoryInterface             $bankHolidayRepository,
        HolidayRepositoryInterface                 $holidayRepository,
        OrderRepositoryInterface                   $orderRepository,
        VehicleHistoryInvoiceRepositoryInterface   $vehicleHistoryInvoiceRepository,
        SettingRepositoryInterface                 $settingRepository,
        ItemRepositoryInterface                    $itemRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->courtesyCarRepository = $courtesyCarRepository;
        $this->carMakeRepository = $carMakeRepository;
        $this->carModelRepository = $carModelRepository;
        $this->staffRepository = $staffRepository;
        $this->vehicleMaintenanceRepository = $vehicleMaintenanceRepository;
        $this->vehicleMaintenanceEventRepository = $vehicleMaintenanceEventRepository;
        $this->companyRepository = $companyRepository;
        $this->glassSupplierRepository = $glassSupplierRepository;
        $this->subContractorRepository = $subContractorRepository;
        $this->bankHolidayRepository = $bankHolidayRepository;
        $this->holidayRepository = $holidayRepository;
        $this->orderRepository = $orderRepository;
        $this->vehicleHistoryInvoiceRepository = $vehicleHistoryInvoiceRepository;
        $this->settingRepository = $settingRepository;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @return mixed
     */
    public function getAdminUser()
    {
        return $this->userRepository->find(1);
    }

    /**
     * @param $data
     * @return void
     */
    public function updateAdmin($data)
    {
        $this->userRepository->update($data, 1);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updatePassword($data, $id)
    {
        return $this->userRepository->update($data, $id);
    }

    /**
     * @return mixed
     */
    public function getCourtesyCars()
    {
        return $this->courtesyCarRepository->allWhere(['*'], ['status' => 1]);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->itemRepository->allWhere(['*'], ['status' => 1]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createItem(array $data)
    {
        return $this->itemRepository->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function updateItem($id, array $data)
    {
        $this->itemRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        return $this->itemRepository->find($id);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function updateCourtesyCar($id, $data)
    {
        $this->courtesyCarRepository->update($data, $id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addCourtesyCar($data)
    {
        return $this->courtesyCarRepository->insert($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCourtesyCar($id)
    {
        return $this->courtesyCarRepository->find($id);
    }

    /**
     * @return mixed
     */
    public function getCarMakes()
    {
        return $this->carMakeRepository->all(['id', 'name']);
    }

    /**
     * @param $searchValue
     * @return int
     */
    public function getCarMakesCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->carMakeRepository->whereLikeCount('name', $searchValue);
        }

        return $this->carMakeRepository->counts();
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder|Collection
     */
    public function getCarMakesPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    )
    {
        return $this->carMakeRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'name'
        );
    }

    /**
     * @return mixed
     */
    public function getCarModelsPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    )
    {
        return $this->carModelRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'name'
        );
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createCarModel($data)
    {
        return $this->carModelRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function updateCarModel($id, $data)
    {
        $this->carModelRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCarModel($id)
    {
        return $this->carModelRepository->find($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createCarMake($data)
    {
        return $this->carMakeRepository->create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCarMake($id)
    {
        return $this->carMakeRepository->find($id);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function updateCarMake($id, $data)
    {
        $this->carMakeRepository->update($data, $id);
    }

    /**
     * @return mixed
     */
    public function getCarModels()
    {
        return $this->carModelRepository->all(['id', 'name']);
    }

    /**
     * @return mixed
     */
    public function getStaffsPaginator()
    {
        return $this->staffRepository->paginateArrayResults();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createStaff($data)
    {
        return $this->staffRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function updateStaff($id, $data)
    {
        $this->staffRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getStaff($id)
    {
        return $this->staffRepository->find($id);
    }

    /**
     * @return VehicleMaintenance|Builder|Collection
     */
    public function getVehicleMaintenances()
    {
        return $this->vehicleMaintenanceRepository->getAllStatus();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createVehicleMaintenance($data)
    {
        return $this->vehicleMaintenanceRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateVehicleMaintenance($id, $data)
    {
        return $this->vehicleMaintenanceRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleMaintenance($id)
    {
        return $this->vehicleMaintenanceRepository->find($id);
    }

    /**
     * @return User[]|Builder[]|Collection
     */
    public function getUsers()
    {
        return $this->userRepository->getAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleMaintenanceEventByVM($id)
    {
        return $this->vehicleMaintenanceEventRepository
            ->allWhere(['*'], ['vehicle_maintenance_id' => $id, 'status' => 1]);
    }

    /**
     * @param $searchValue
     * @return int
     */
    public function getCompaniesCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->carMakeRepository->whereLikeCount('name', $searchValue);
        }

        return $this->carMakeRepository->counts();
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder|Collection
     */
    public function getCompaniesPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    )
    {
        return $this->companyRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'name'
        );
    }

    /**
     * @return mixed
     */
    public function getGlassSuppliersPaginator()
    {
        return $this->glassSupplierRepository->paginateArrayResults();
    }

    /**
     * @param $searchValue
     * @return int
     */
    public function getSubContractorsCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->subContractorRepository->whereLikeCount('name', $searchValue);
        }

        return $this->subContractorRepository->counts();
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder|Collection
     */
    public function getSubContractorsPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    )
    {
        return $this->subContractorRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'name'
        );
    }

    /**
     * @return mixed
     */
    public function getBankHolidaysPaginator()
    {
        return $this->bankHolidayRepository->paginateArrayResults();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createBankHoliday($data)
    {
        return $this->bankHolidayRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function updateBankHoliday($id, $data)
    {
        $this->bankHolidayRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getBankHoliday($id)
    {
        return $this->bankHolidayRepository->find($id);
    }

    /**
     * @param array $data
     * @return Holiday[]|Builder[]|Collection
     */
    public function getHolidaysFilter(array $data)
    {
        return $this->holidayRepository->getHolidaysFilter($data);
    }

    /**
     * @return Builder|Collection|Holiday
     */
    public function getHolidays()
    {
        return $this->holidayRepository->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getStaffs()
    {
        return $this->staffRepository->getAllAndName();
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function updateHoliday($id, array $data)
    {
        $this->holidayRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getHoliday($id)
    {
        return $this->holidayRepository->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addHoliday(array $data)
    {
        return $this->holidayRepository->create($data);
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orderRepository->allWhere(['*'], ['status' => 1]);
    }

    /**
     * @param array $data
     * @param $id
     * @return void
     */
    public function updateLogo(array $data, $id)
    {
        $this->userRepository->update($data, $id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createSubUser($data)
    {
        return $this->userRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function updateSubUser($id, $data)
    {
        $this->userRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSubUser($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleMaintenanceEventById($id)
    {
        return $this->vehicleMaintenanceEventRepository->find($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createVehicleMaintenanceEvent($data)
    {
        return $this->vehicleMaintenanceEventRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateVehicleMaintenanceEvent($id, $data)
    {
        return $this->vehicleMaintenanceEventRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteVehicleMaintenanceEvent($id)
    {
        $this->vehicleMaintenanceEventRepository->update([
            'status' => 0
        ], $id);
    }

    /**
     * @param array $dates
     * @return LengthAwarePaginator|mixed
     */
    public function getVehicleHistoryInvoicesPaginator(array $dates = [])
    {
        if (count($dates) > 0) {
            return $this->vehicleHistoryInvoiceRepository->getAllFilter($dates['start'], $dates['end']);
        }

        return $this->vehicleHistoryInvoiceRepository->paginateArrayResults();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getAmount(string $name)
    {
        return $this->settingRepository->findOneBy(['name' => $name]);
    }

    /**
     * @return mixed
     */
    public function getSubContractors()
    {
        return $this->subContractorRepository->all(['id', 'name']);
    }

    /**
     * @param string $searchValue
     * @return int
     */
    public function getCarModelsCount(string $searchValue = null): int
    {
        if ($searchValue) {
            return $this->carModelRepository->whereLikeCount('name', $searchValue);
        }

        return $this->carModelRepository->counts();
    }
}
