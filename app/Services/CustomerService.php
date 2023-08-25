<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\GlassSupplierRepositoryInterface;
use App\Repositories\GroupRepositoryInterface;
use App\Repositories\SubContractorRepositoryInterface;
use App\Repositories\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerService
 * @package App\Services
 */
class CustomerService
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
     * GlassSupplierRepositoryInterface depend injection.
     *
     * @var GlassSupplierRepositoryInterface
     */
    private $glassSupplierRepository;

    /**
     * GroupRepositoryInterface depend injection.
     *
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * VehicleRepositoryInterface depend injection.
     *
     * @var VehicleRepositoryInterface
     */
    private $vehicleRepository;

    /**
     * SubContractorRepositoryInterface depend injection.
     *
     * @var SubContractorRepositoryInterface
     */
    private $subContractorRepository;

    public function __construct(
        CustomerRepositoryInterface      $customerRepository,
        CompanyRepositoryInterface       $companyRepository,
        GlassSupplierRepositoryInterface $glassSupplierRepository,
        SubContractorRepositoryInterface $subContractorRepository,
        GroupRepositoryInterface         $groupRepository,
        VehicleRepositoryInterface       $vehicleRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->companyRepository = $companyRepository;
        $this->glassSupplierRepository = $glassSupplierRepository;
        $this->subContractorRepository = $subContractorRepository;
        $this->groupRepository = $groupRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @return int
     */
    public function getCustomerCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->customerRepository->whereLikeCount('first_name', $searchValue);
        }

        return $this->customerRepository->counts();
    }


    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder[]|Collection
     */
    public function getCustomersPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    )
    {
        return $this->customerRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'first_name'
        );
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder[]|Collection
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
     * @param null $searchValue
     * @return int
     */
    public function getCompaniesCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->companyRepository->whereLikeCount('name', $searchValue);
        }

        return $this->companyRepository->counts();
    }

    /**
     * @return mixed
     */
    public function getCompaniesName()
    {
        return $this->companyRepository->all(['id', 'name'], [], 'name', 'asc');
    }

    /**
     * @return Vehicle[]|Builder[]|Collection
     */
    public function getVehicles()
    {
        return $this->vehicleRepository->getVehicleMaleModel();
    }

    /**
     * @return mixed
     */
    public function getAllGroups()
    {
        return $this->groupRepository->allWhere(['id', 'name'], ['status' => 1]);
    }

    /**
     * @param array $fields
     * @return mixed
     */
    public function getGroups(array $fields = ['*'])
    {
        return $this->groupRepository->allWhere($fields);
    }

    /**
     * @param $customerId
     * @param $groupId
     * @param $userId
     * @return void
     */
    public function setCustomerGroup($customerId, $groupId, $userId)
    {
        $this->customerRepository->setCustomerGroup($customerId, $groupId, $userId);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createCustomer(array $data)
    {
        return $this->customerRepository->create($data);
    }

    /**
     * @return int
     */
    public function groupsCount(): int
    {
        return $this->groupRepository->counts();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createCompany(array $data)
    {
        return $this->companyRepository->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createGlassSupplier(array $data)
    {
        return $this->glassSupplierRepository->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createSubContractor(array $data)
    {
        return $this->subContractorRepository->create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCustomerById($id)
    {
        return $this->customerRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCompanyById($id)
    {
        return $this->companyRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getGlassSupplierById($id)
    {
        return $this->glassSupplierRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSubContractorById($id)
    {
        return $this->subContractorRepository->find($id);
    }

    /**
     * @param $customerId
     * @param $vehicleId
     * @param $userId
     * @return bool
     */
    public function linkVehicle($customerId, $vehicleId, $userId): bool
    {
        $exists = $this->customerRepository->alreadyLinked($customerId, $vehicleId);

        if (count($exists) > 0) {
            return false;
        }

        $this->customerRepository->linkVehicle($customerId, $vehicleId, $userId);

        return true;
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function updateCustomer($id, array $data)
    {
        $this->customerRepository->update($data, $id);
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function updateCompany($id, array $data)
    {
        $this->companyRepository->update($data, $id);
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function updateGlassSupplier($id, array $data)
    {
        $this->glassSupplierRepository->update($data, $id);
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function updateSubContractor($id, array $data)
    {
        $this->subContractorRepository->update($data, $id);
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder|Collection
     */
    public function getGlassSuppliersPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    )
    {
        return $this->glassSupplierRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'name'
        );
    }

    /**
     * @param null $searchValue
     * @return int
     */
    public function getGlassSuppliersCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->glassSupplierRepository->whereLikeCount('name', $searchValue);
        }

        return $this->glassSupplierRepository->counts();
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder[]|Collection
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
     * @param null $searchValue
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
     * @param array $columns
     * @return mixed
     */
    public function getGlassSuppliers(array $columns = ['*'])
    {
        return $this->glassSupplierRepository->all($columns);
    }

    /**
     * @return Customer[]|Collection
     */
    public function getAllCustomers()
    {
       return $this->customerRepository->getAllAndName();
    }

    /**
     * @param string|null $query
     * @return array|mixed
     */
    public function getCustomerByName(?string $query)
    {
        if (!$query) {
            return [];
        }

        return $this->customerRepository
            ->findWhereLike('surname', $query, 0, ['id', DB::raw("CONCAT(first_name, ' ', surname) as text")]);
    }

    /**
     * @param string|null $query
     * @return array|mixed
     */
    public function getCompaniesByName(?string $query)
    {
        if (!$query) {
            return [];
        }

        return $this->companyRepository
            ->findWhereLike('name', $query, 0, ['id', 'name as text']);
    }

    /**
     * @param array|null $where
     * @return array|mixed
     */
    public function getCompanies(?Array $where)
    {
        return $this->companyRepository->allWhere(['*'], $where);
    }
}
