<?php

namespace App\Http\Controllers;

use App\Helpers\StaticMessages;
use App\Services\CustomerService;
use App\Services\VehicleService;
use App\Traits\ViewTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    use ViewTrait;

    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var VehicleService
     */
    private $vehicleService;

    /**
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService, VehicleService $vehicleService)
    {
        $this->customerService = $customerService;
        $this->vehicleService = $vehicleService;
    }

    /**
     * Show the customer page.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->customerService->getCustomerCount();
            $totalRecordsWithFilter = $this->customerService->getCustomerCount($this->searchValue);

            $customers = $this->customerService->getCustomersPaginator(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($customers as $customer) {
                $route = route('customer.edit-customer', $customer->id);
                $company = $customer->company;
                $results[] = [
                    'surname' => $customer->surname,
                    'firstName' => $customer->first_name,
                    'company' => $company ? $company->name : '',
                    'address' => $customer->address_1,
                    'postcode' => $customer->postcode,
                    'mobile' => $customer->mobile,
                    'edit' => "<a class='list-inline-item'
                               href='$route'>
                                <button class='btn btn-success btn-sm rounded-0' type='button'
                                        data-toggle='tooltip'
                                        data-placement='top' title='Edit'><i class='fa fa-edit'></i></button>
                            </a>",
                    'send' => ''
                ];
            }

            return response()
                ->json([
                    'draw' => intval($this->draw),
                    'iTotalRecords' => $totalRecords,
                    'iTotalDisplayRecords' => $totalRecordsWithFilter,
                    'aaData' => $results
                ]);
        }

        return view('customer.customer.index');
    }

    /**
     * create a new customer.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function newCustomer(Request $request)
    {
        if ($request->isMethod('post')) {
            $customer = $this->customerService->createCustomer($this->customerPayload($request));

            $this->customerGroupRelate($request, $customer->id, $this->customerService);

            return redirect()->route('customer.customer-link-vehicle', $customer->id);
        }

        $companies = $this->customerService->getCompaniesName();
        $groups = $this->customerService->getGroups(['id', 'name']);

        return view('customer.customer.new', [
            'companies' => $companies,
            'groups' => $groups
        ]);
    }

    /**
     * update the customer.
     *
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editCustomer(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->customerService->updateCustomer($id, $this->customerPayload($request));

            $this->customerGroupRelate($request, $id, $this->customerService);

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $customer = $this->customerService->getCustomerById($id);
        $companies = $this->customerService->getCompaniesName();
        $vehicles = $this->customerService->getVehicles();
        $groups = $this->customerService->getAllGroups();

        return view('shared.customer-edit', [
            'companies' => $companies,
            'customer' => $customer,
            'vehicles' => $vehicles,
            'groups' => $groups
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function customerLinkVehicle(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->customerService->createCompany($request->all());

            return redirect()->route('customer')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $vehicles = $this->customerService->getVehicles();
        $carMakes = $this->vehicleService->getCarMakes(['id', 'name']);
        $canView  = $this->canViewAddVehicle($request);

        return view('shared.customer-link-vehicle', [
            'vehicles' => $vehicles,
            'id' => $id,
            'carMakes' => $carMakes,
            'canView' => $canView
        ]);
    }

    /**
     * Show the customer companies page.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function companies(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->customerService->getCompaniesCount();
            $totalRecordsWithFilter = $this->customerService->getCompaniesCount($this->searchValue);

            $companies = $this->customerService->getCompaniesPaginator(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($companies as $company) {
                $route = route('customer.edit-company', $company->id);
                $results[] = [
                    'name' => $company->name,
                    'address_1' => $company->address_1,
                    'address_2' => $company->address_2,
                    'city' => $company->city,
                    'county' => $company->county,
                    'postcode' => $company->postcode,
                    'edit' => "<a class='list-inline-item'
                               href='$route'>
                                <button class='btn btn-success btn-sm rounded-0' type='button'
                                        data-toggle='tooltip'
                                        data-placement='top' title='Edit'><i class='fa fa-edit'></i></button>
                            </a>",
                ];
            }

            return response()
                ->json([
                    'draw' => intval($this->draw),
                    'iTotalRecords' => $totalRecords,
                    'iTotalDisplayRecords' => $totalRecordsWithFilter,
                    'aaData' => $results
                ]);
        }

        return view('customer.companies.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newCompany(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->customerService->createCompany($request->all());

            return redirect()->route('customer.companies')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }
        $companies = $this->customerService->getCompanies([]);
        return view('customer.companies.new', compact('companies'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editCompany(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->customerService->updateCompany($id, $request->all());

            return redirect()->route('admin.manage-companies')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $company = $this->customerService->getCompanyById($id);
        $allCompaniesWithoutCurrent =  $this->customerService->getCompanies([['id', '!=', $id]]);
        return view('customer.companies.edit', [
            'company' => $company,
            'allCompaniesWithoutCurrent' => $allCompaniesWithoutCurrent
        ]);
    }

    /**
     * Show the glass suppliers page.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function glassSuppliers(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->customerService->getGlassSuppliersCount();
            $totalRecordsWithFilter = $this->customerService->getGlassSuppliersCount($this->searchValue);

            $glassSuppliers = $this->customerService->getGlassSuppliersPaginator(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($glassSuppliers as $glassSupplier) {
                $route = route('customer.edit-company', $glassSupplier->id);
                $results[] = [
                    'name' => $glassSupplier->name,
                    'edit' => "<a class='list-inline-item'
                               href='$route'>
                                <button class='btn btn-success btn-sm rounded-0' type='button'
                                        data-toggle='tooltip'
                                        data-placement='top' title='Edit'><i class='fa fa-edit'></i></button>
                            </a>",
                ];
            }

            return response()
                ->json([
                    'draw' => intval($this->draw),
                    'iTotalRecords' => $totalRecords,
                    'iTotalDisplayRecords' => $totalRecordsWithFilter,
                    'aaData' => $results
                ]);
        }

        return view('customer.glass-suppliers.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'vat' => ['required', 'numeric'],
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     * @throws ValidationException
     */
    public function newGlassSupplier(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $this->customerService->createGlassSupplier($request->all());

            return redirect()->route('customer.glass-suppliers')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('customer.glass-suppliers.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editGlassSupplier(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->customerService->updateGlassSupplier($id, $request->all());

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $glassSupplier = $this->customerService->getGlassSupplierById($id);

        return view('customer.glass-suppliers.edit', [
            'glassSupplier' => $glassSupplier
        ]);
    }

    /**
     * Show the glass suppliers page.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function subContractors(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->customerService->getSubContractorsCount();
            $totalRecordsWithFilter = $this->customerService->getSubContractorsCount($this->searchValue);

            $subContractors = $this->customerService->getSubContractorsPaginator(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($subContractors as $subContractor) {
                $route = route('customer.edit-sub-contractors', $subContractor->id);
                $results[] = [
                    'name' => $subContractor->name,
                    'edit' => "<a class='list-inline-item'
                               href='$route'>
                                <button class='btn btn-success btn-sm rounded-0' type='button'
                                        data-toggle='tooltip'
                                        data-placement='top' title='Edit'><i class='fa fa-edit'></i></button>
                            </a>",
                ];
            }

            return response()
                ->json([
                    'draw' => intval($this->draw),
                    'iTotalRecords' => $totalRecords,
                    'iTotalDisplayRecords' => $totalRecordsWithFilter,
                    'aaData' => $results
                ]);
        }

        return view('customer.sub-contractors.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newSubContractor(Request $request)
    {
        if ($request->isMethod('post')) {
            $payload = $this->subContractorPayload($request);

            $this->customerService->createSubContractor($payload);

            return redirect()->route('customer.sub-contractors')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('customer.sub-contractors.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editSubContractor(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $payload = $this->subContractorPayload($request);

            $this->customerService->updateSubContractor($id, $payload);

            return redirect()->route('customer.sub-contractors')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $subContractor = $this->customerService->getSubContractorById($id);

        return view('customer.sub-contractors.edit', [
            'subContractor' => $subContractor
        ]);
    }

    /**
     * @param Request $request
     * @param $customerId
     * @param $vehicleId
     * @return JsonResponse
     */
    public function linkVehicle(Request $request, $customerId, $vehicleId): JsonResponse
    {
        $ok = $this->customerService->linkVehicle($customerId, $vehicleId, $request->user()->id);

        if (!$ok) {
            return response()->json([
                'error' => 'already linked successfully'
            ]);
        }

        return response()->json([
            'message' => 'linked successfully',
            'customerId' => $customerId
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchName(Request $request): JsonResponse
    {
        $customers = $this->customerService->getCustomerByName($request->query('term'));

        return response()->json([
            'results' => $customers
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCompany(Request $request): JsonResponse
    {
        $company = $this->customerService->getCompaniesByName($request->query('term'));

        return response()->json([
            'results' => $company
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function subContractorPayload(Request $request): array
    {
        $payload = $request->all();
        $payload['status'] = 1;
        $payload['user_id'] = $request->user()->id;

        return $payload;
    }
}
