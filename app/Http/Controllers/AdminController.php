<?php

namespace App\Http\Controllers;

use App\Helpers\StaticMessages;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Helpers\BasicHelpers;
use Illuminate\Validation\Rule;
use Srmklive\PayPal\Services\PayPal;
use Throwable;

class AdminController extends Controller
{
    /**
     * @var AdminService
     */
    private $adminService;

    /**
     * Create a new controller instance.
     *
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function updateSetting(Request $request)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateAdmin($this->adminPayload($request));

            return redirect()->back()
                ->with([
                    'message', StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $admin = $this->adminService->getAdminUser();

        return view('admin.update-setting.index', [
            'admin' => $admin
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function changePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $salt = BasicHelpers::generateSalt();

            $this->adminService->updatePassword([
                'password_salt' => $salt,
                'password' => BasicHelpers::encryptPassword($request->get('password'), $salt)
            ], $request->user()->id);

            return redirect()->back()
                ->with([
                    'message', StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.change-password.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     * @throws Throwable
     */
    public function buyTextCredit(Request $request)
    {
        if ($request->isMethod('post')) {
            $provider = new PayPal;
            $provider->setApiCredentials(config('paypal'));

            switch ($request->get('item_number')) {
                case 100:
                    $amt = $this->adminService->getAmount('cost_per_100_text')->value;
                    break;
                case 250:
                    $amt = $this->adminService->getAmount('cost_per_250_text')->value;
                    break;
                case 500:
                    $amt = $this->adminService->getAmount('cost_per_500_text')->value;
                    break;
                case 750:
                    $amt = $this->adminService->getAmount('cost_per_750_text')->value;
                    break;
                case 1000:
                    $amt = $this->adminService->getAmount('cost_per_1000_text')->value;
                    break;
                case 1500:
                    $amt = $this->adminService->getAmount('cost_per_1500_text')->value;
                    break;
                case 2000:
                    $amt = $this->adminService->getAmount('cost_per_2000_text')->value;
                    break;
                case 3000:
                    $amt = $this->adminService->getAmount('cost_per_3000_text')->value;
                    break;
                case 4000:
                    $amt = $this->adminService->getAmount('cost_per_4000_text')->value;
                    break;
            }

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('successTransaction'),
                    "cancel_url" => route('cancelTransaction'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "GBP",
                            "value" => number_format($amt, 2)
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }

                return redirect()
                    ->route('createTransaction')
                    ->with('error', 'Something went wrong.');
            } else {
                return redirect()
                    ->route('createTransaction')
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        }

        return view('admin.buy-text-credit.index');
    }

    /**
     * success transaction.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function successTransaction(Request $request): RedirectResponse
    {
        $provider = new PayPal;

        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('createTransaction')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * cancel transaction.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function cancelTransaction(Request $request): RedirectResponse
    {
        return redirect()
            ->route('createTransaction')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    /**
     * @return Application|Factory|View
     */
    public function manageHistory()
    {
        $items = $this->adminService->getItems();

        return view('admin.manage-history.index', [
            'items' => $items
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newHistory(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createItem($request->all());

            return redirect()
                ->route('admin.manage-history')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.manage-history.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editHistory(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateItem($id, $request->all());

            return redirect()->route('admin.manage-history')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $item = $this->adminService->getItem($id);

        return view('admin.manage-history.edit', [
            'item' => $item,
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function manageCourtesyCar()
    {
        $courtesyCars = $this->adminService->getCourtesyCars();

        return view('admin.manage-courtesy-car.index', [
            'courtesyCars' => $courtesyCars
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newCourtesyCar(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->addCourtesyCar($request->except('_token'));

            return redirect()->route('admin.manage-courtesy-car')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $carMakes = $this->adminService->getCarMakes();
        $carModels = $this->adminService->getCarModels();

        return view('admin.manage-courtesy-car.new', [
            'carMakes' => $carMakes,
            'carModels' => $carModels
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveCourtesyCar(Request $request): RedirectResponse
    {
        $this->adminService->addCourtesyCar($request->except('_token'));

        return redirect()->route('admin.manage-courtesy-car')
            ->with([
                'message' => StaticMessages::$SAVED,
                'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
            ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editCourtesyCar(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateCourtesyCar($id, $request->all());

            return redirect()->route('admin.manage-courtesy-car')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $courtesyCar = $this->adminService->getCourtesyCar($id);
        $carMakes = $this->adminService->getCarMakes();
        $carModels = $this->adminService->getCarModels();

        return view('admin.manage-courtesy-car.edit', [
            'courtesyCar' => $courtesyCar,
            'carMakes' => $carMakes,
            'carModels' => $carModels
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function manageCarMake(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->adminService->getCarMakesCount();
            $totalRecordsWithFilter = $this->adminService->getCarMakesCount($this->searchValue);

            $carMakes = $this->adminService->getCarMakesPaginator(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($carMakes as $carMake) {
                $route = route('admin.edit-manage-car-make', $carMake->id);
                $results[] = [
                    'name' => $carMake->name,
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

        return view('admin.manage-car-make.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newCarMake(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createCarMake($request->all());

            return redirect()->route('admin.manage-car-make')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.manage-car-make.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editCarMake(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateCarMake($id, $request->all());

            return redirect()->route('admin.manage-car-make')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $carMake = $this->adminService->getCarMake($id);

        return view('admin.manage-car-make.edit', [
            'carMake' => $carMake,
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function manageCarModel(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->adminService->getCarModelsCount();
            $totalRecordsWithFilter = $this->adminService->getCarModelsCount($this->searchValue);

            $carModels = $this->adminService->getCarModelsPaginator(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($carModels as $carModel) {
                $route = route('admin.edit-manage-car-model', $carModel->id);
                $results[] = [
                    'name' => $carModel->name,
                    'make' => $carModel->carMake ? $carModel->carMake->name : '',
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

        return view('admin.manage-car-model.index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newCarModel(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createCarModel($request->all());

            return redirect()->route('admin.manage-car-model')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $carMakes = $this->adminService->getCarMakes();

        return view('admin.manage-car-model.new', [
            'carMakes' => $carMakes
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editCarModel(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateCarModel($id, $request->all());

            return redirect()->route('admin.manage-car-model')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $carModel = $this->adminService->getCarModel($id);
        $carMakes = $this->adminService->getCarMakes();

        return view('admin.manage-car-model.edit', [
            'carModel' => $carModel,
            'carMakes' => $carMakes
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function manageUsers()
    {
        $users = $this->adminService->getUsers();

        return view('admin.manage-users.index', [
            'users' => $users
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function manageStaff()
    {
        $staffs = $this->adminService->getStaffsPaginator();

        return view('admin.manage-staff.index', [
            'staffs' => $staffs
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newStaff(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createStaff($request->all());

            return redirect()->route('admin.manage-staff')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.manage-staff.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editStaff(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateStaff($id, $request->all());

            return redirect()->route('admin.manage-staff')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $staff = $this->adminService->getStaff($id);

        return view('admin.manage-staff.edit', [
            'staff' => $staff,
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function vehicleMaintenance()
    {
        $vehicleMaintenances = $this->adminService->getVehicleMaintenances();

        return view('admin.vehicle-maintenance.index', [
            'vehicleMaintenances' => $vehicleMaintenances
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newVehicleMaintenance(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createVehicleMaintenance($request->all());

            return redirect()->route('admin.vehicle-maintenance')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.vehicle-maintenance.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editVehicleMaintenance(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateVehicleMaintenance($id, $request->all());

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $vehicleMaintenance = $this->adminService->getVehicleMaintenance($id);
        $users = $this->adminService->getUsers();
        $events = $this->adminService->getVehicleMaintenanceEventByVM($id);

        return view('admin.vehicle-maintenance.edit', [
            'vehicleMaintenance' => $vehicleMaintenance,
            'users' => $users,
            'events' => $events
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function manageCompanies(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->adminService->getCompaniesCount();
            $totalRecordsWithFilter = $this->adminService->getCompaniesCount($this->searchValue);

            $companies = $this->adminService->getCompaniesPaginator(
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

        return view('admin.manage-companies.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function manageGlassSupplier()
    {
        $glassSuppliers = $this->adminService->getGlassSuppliersPaginator();

        return view('admin.manage-glass-supplier.index', [
            'glassSuppliers' => $glassSuppliers
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function manageSubContractor(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->adminService->getSubContractorsCount();
            $totalRecordsWithFilter = $this->adminService->getSubContractorsCount($this->searchValue);

            $subContractors = $this->adminService->getSubContractorsPaginator(
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

        return view('admin.manage-sub-contractor.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function manageBankHolidays()
    {
        $bankHolidays = $this->adminService->getBankHolidaysPaginator();

        return view('admin.manage-bank-holidays.index', [
            'bankHolidays' => $bankHolidays
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newBankHoliday(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createBankHoliday(array_merge($request->all(), [
                'status' => 1,
                'user_id' => $request->user()->id
            ]));

            return redirect()->route('admin.manage-bank-holiday')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.manage-bank-holidays.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editBankHoliday(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateBankHoliday($id, $request->all());

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $bankHoliday = $this->adminService->getBankHoliday($id);

        return view('admin.manage-bank-holidays.edit', [
            'bankHoliday' => $bankHoliday,
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function manageAbsencePeriod(Request $request)
    {
        $staff = null;

        if ($request->isMethod('post')) {
            $holidays = $this->adminService->getHolidaysFilter($request->all());
            if ($request->get('staff_id') !== '---') {
                $staff = $this->adminService->getStaff($request->get('staff_id'));
                $used2016 = 0;
                $used2017 = 0;
                $used2018 = 0;
                $used2019 = 0;
                $used2020 = 0;
                $used2021 = 0;
                $used2022 = 0;
                $used2023 = 0;
                $used2024 = 0;

                foreach ($holidays as $holiday) {
                    switch (Carbon::create($holiday->date_from)->format('Y')) {
                        case '2016':
                            $used2016 += BasicHelpers::getDays($holiday);
                            break;
                        case '2017':
                            $used2017 += BasicHelpers::getDays($holiday);
                            break;
                        case '2018':
                            $used2018 += BasicHelpers::getDays($holiday);
                            break;
                        case '2019':
                            $used2019 += BasicHelpers::getDays($holiday);
                            break;
                        case '2020':
                            $used2020 += BasicHelpers::getDays($holiday);
                            break;
                        case '2021':
                            $used2021 += BasicHelpers::getDays($holiday);
                            break;
                        case '2022':
                            $used2022 += BasicHelpers::getDays($holiday);
                            break;
                        case '2023':
                            $used2023 += BasicHelpers::getDays($holiday);
                            break;
                        case '2024':
                            $used2024 += BasicHelpers::getDays($holiday);
                            break;
                    }
                }

                $staff->holiday_entitlement_2016 = [
                    'entitlement' => $staff->holiday_entitlement_2016,
                    'used' => $used2016,
                    'remaining' => $staff->holiday_entitlement_2016 - $used2016
                ];
                $staff->holiday_entitlement_2017 = [
                    'entitlement' => $staff->holiday_entitlement_2017,
                    'used' => $used2017,
                    'remaining' => $staff->holiday_entitlement_2017 - $used2017
                ];
                $staff->holiday_entitlement_2018 = [
                    'entitlement' => $staff->holiday_entitlement_2018,
                    'used' => $used2018,
                    'remaining' => $staff->holiday_entitlement_2018 - $used2018
                ];
                $staff->holiday_entitlement_2019 = [
                    'entitlement' => $staff->holiday_entitlement_2019,
                    'used' => $used2019,
                    'remaining' => $staff->holiday_entitlement_2019 - $used2019
                ];
                $staff->holiday_entitlement_2020 = [
                    'entitlement' => $staff->holiday_entitlement_2020,
                    'used' => $used2020,
                    'remaining' => $staff->holiday_entitlement_2020 - $used2020
                ];
                $staff->holiday_entitlement_2021 = [
                    'entitlement' => $staff->holiday_entitlement_2021,
                    'used' => $used2021,
                    'remaining' => $staff->holiday_entitlement_2021 - $used2021
                ];
                $staff->holiday_entitlement_2022 = [
                    'entitlement' => $staff->holiday_entitlement_2022,
                    'used' => $used2022,
                    'remaining' => $staff->holiday_entitlement_2022 - $used2022
                ];
                $staff->holiday_entitlement_2023 = [
                    'entitlement' => $staff->holiday_entitlement_2023,
                    'used' => $used2023,
                    'remaining' => $staff->holiday_entitlement_2023 - $used2023
                ];
                $staff->holiday_entitlement_2024 = [
                    'entitlement' => $staff->holiday_entitlement_2024,
                    'used' => $used2024,
                    'remaining' => $staff->holiday_entitlement_2024 - $used2024
                ];
            }
        } else {
            $holidays = $this->adminService->getHolidays();
        }

        $staffs = $this->adminService->getStaffs();

        return view('admin.manage-absence-period.index', [
            'staffs' => $staffs,
            'holidays' => $holidays,
            'staff' => $staff,
            'year' => $request->get('year') ?? '',
            'staff_id' => $request->get('staff_id') ?? '',
            'type' => $request->get('type') ?? ''
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function holidayValidator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'type' => ['required', Rule::notIn('---')],
            'staff_id' => ['required', Rule::notIn('---')],
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newHoliday(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->holidayValidator($request->all());

            if ($validator->fails()) {
                return redirect()->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $this->adminService->addHoliday($this->holidayPayload($request));

            return redirect()->route('admin.manage-absence-period')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $staffs = $this->adminService->getStaffs();

        return view('admin.manage-absence-period.new', [
            'staffs' => $staffs
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editHoliday(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $validator = $this->holidayValidator($request->all());

            if ($validator->fails()) {
                return redirect()->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $this->adminService->updateHoliday($id, $request->all());

            return redirect()->route('admin.manage-absence-period')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $holiday = $this->adminService->getHoliday($id);
        $staffs = $this->adminService->getStaffs();

        return view('admin.manage-absence-period.edit', [
            'holiday' => $holiday,
            'staffs' => $staffs
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function viewIcomssInvoices()
    {
        $orders = $this->adminService->getOrders();

        return view('admin.view-icomss-invoices.index', ['orders' => $orders]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function uploadLogo(Request $request)
    {
        if ($request->isMethod('post')) {
            $filename = BasicHelpers::upload($request);

            $this->adminService->updateLogo(['logo' => $filename], $request->user()->id);

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.upload-logo.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function incomeReport()
    {
        return view('admin.income-report.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function invoiceIncomeReportValidator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'start' => ['required', 'date_format:Y-m-d', 'before_or_equal:end'],
            'end' => ['required', 'date_format:Y-m-d', 'after_or_equal:start'],
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function invoiceIncomeReport(Request $request)
    {
        $start = null;
        $end = null;

        if ($request->isMethod('post')) {
            $validator = $this->invoiceIncomeReportValidator($request->all());

            if ($validator->fails()) {
                return redirect()->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $start = $request->get('start');
            $end = $request->get('end');
            $vehicleHistoryInvoices = $this->adminService->getVehicleHistoryInvoicesPaginator($request->all());
        } else {
            $vehicleHistoryInvoices = $this->adminService->getVehicleHistoryInvoicesPaginator();
        }


        return view('admin.invoice-income-report.index', [
            'vehicleHistoryInvoices' => $vehicleHistoryInvoices,
            'start' => $start,
            'end' => $end
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createSubUser($this->userPayload($request));

            return redirect()->route('admin.manage-users')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.manage-users.create');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editUser(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->adminService->updateSubUser($id, $request->all());

            return redirect()->route('admin.manage-users')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $user = $this->adminService->getSubUser($id);

        return view('admin.manage-users.edit', [
            'user' => $user
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function newEvent(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $this->adminService->createVehicleMaintenanceEvent(array_merge($request->all(), [
                'vehicle_maintenance_id' => $id,
                'status' => 1
            ]));

            return redirect()->route('admin.vehicle-maintenance')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('admin.vehicle-maintenance-event.new', [
            'id' => $id
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editEvent(Request $request, $id)
    {
        if ($request->isMethod('delete')) {
            dd($id);
            $this->adminService->deleteVehicleMaintenanceEvent($id);

            return redirect()->route('admin.vehicle-maintenance')
                ->with([
                    'message' => StaticMessages::$DELETE,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        if ($request->isMethod('put')) {
            $this->adminService->updateVehicleMaintenanceEvent($id, $request->all());

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_INFO
                ]);
        }

        $event = $this->adminService->getVehicleMaintenanceEventById($id);

        return view('admin.vehicle-maintenance-event.edit', [
            'event' => $event
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function userPayload(Request $request): array
    {
        $payload = $request->all();

        $payload['password_salt'] = BasicHelpers::generateSalt();
        $payload['password'] = BasicHelpers::encryptPassword($payload['password'], $payload['password_salt']);

        return $payload;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function adminPayload(Request $request): array
    {
        $payload = $request->all();

        $payload['vat_registered'] = $payload['vat_registered'] === 'on' ? 1 : 0;
        $payload['enable_cron'] = $payload['enable_cron'] === 'on' ? 1 : 0;
        $payload['show_payment_method'] = $payload['show_payment_method'] === 'on' ? 1 : 0;
        $payload['show_cost'] = $payload['show_cost'] === 'on' ? 1 : 0;
        $payload['show_amount_paid'] = $payload['show_amount_paid'] === 'on' ? 1 : 0;
        $payload['show_company'] = $payload['show_company'] === 'on' ? 1 : 0;
        $payload['show_invoice_margin'] = $payload['show_invoice_margin'] === 'on' ? 1 : 0;

        return $payload;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function holidayPayload(Request $request): array
    {
        $payload = $request->all();
        $payload['status'] = 1;
        $payload['user_id'] = $request->user()->id;

        return $payload;
    }
}
