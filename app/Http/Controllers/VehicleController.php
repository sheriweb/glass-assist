<?php

namespace App\Http\Controllers;

use App\Helpers\StaticMessages;
use App\Http\Requests\CreateWhatWindscreenLookupRequest;
use App\Services\CustomerService;
use App\Services\VehicleService;
use App\Services\WhatWindscreenApiService;
use App\Traits\ViewTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VehicleController extends Controller
{
    use ViewTrait;

    /**
     * @var VehicleService
     */
    private $vehicleService;
    /**
     * @var CustomerService
     */
    private $customerService;
    /**
     * @var WhatWindscreenApiService
     */
    private $whatWindscreenApiService;

    /**
     * @param VehicleService $vehicleService
     * @param CustomerService $customerService
     */
    public function __construct(VehicleService $vehicleService, CustomerService $customerService, WhatWindscreenApiService $whatWindscreenApiService )
    {
        $this->vehicleService = $vehicleService;
        $this->customerService = $customerService;
        $this->whatWindscreenApiService = $whatWindscreenApiService;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            // Total records
            $totalRecords = $this->vehicleService->getVehiclesCount();
            $totalRecordsWithFilter = $this->vehicleService->getVehiclesCount($this->searchValue);

            $vehicles = $this->vehicleService->getVehiclesPaginator(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($vehicles as $vehicle) {
                $route = route('edit-vehicle', $vehicle->id);
                $carMake = $vehicle->carMake;
                $carModel = $vehicle->carModel;
                $results[] = [
                    'reg_no'     => $vehicle->reg_no,
                    'make_id'    => $carMake ? $carMake->name : '',
                    'model_id'   => $carModel ? $carModel->name : '',
                    'vin_number' => $vehicle->vin_number,
                    'due_date_1' => $vehicle->due_date_1,
                    'due_date_2' => $vehicle->due_date_2,
                    'edit'       => "<a class='list-inline-item'
                               href='$route'>
                                <button class='btn btn-success btn-sm rounded-0' type='button'
                                        data-toggle='tooltip'
                                        data-placement='top' title='Edit'><i class='fa fa-edit'></i></button>
                            </a>",
                ];
            }

            return response()
                ->json(
                    [
                        'draw'                 => intval($this->draw),
                        'iTotalRecords'        => $totalRecords,
                        'iTotalDisplayRecords' => $totalRecordsWithFilter,
                        'aaData'               => $results
                    ]
                );
        }

        return view('vehicle/index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newVehicle(Request $request)
    {
        if ($request->isMethod('post')) {
            $payload = $this->getVehiclePayload($request);

            $this->vehicleService->createVehicle($payload);

            return redirect()->route('vehicle')
                ->with(
                    [
                        'message'    => StaticMessages::$SAVED,
                        'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                    ]
                );
        }

        $vehicles = $this->customerService->getVehicles();
        $canView = $this->canViewAddVehicle($request);
        $carMakes = $this->vehicleService->getCarMakes(['id', 'name']);

        return view(
            'vehicle.new',
            [
                'canView'  => $canView,
                'carMakes' => $carMakes,
                'vehicles' => $vehicles
            ]
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editVehicle(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $payload = $this->getVehiclePayload($request);

            $this->vehicleService->updateCustomer($id, $payload);

            return redirect()->back()
                ->with(
                    [
                        'message'    => StaticMessages::$UPDATED,
                        'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                    ]
                );
        }

        $vehicle = $this->vehicleService->getVehicleById($id);
        $canView = $this->canViewAddVehicle($request);
        $carMakes = $this->vehicleService->getCarMakes(['id', 'name']);

        return view(
            'vehicle.edit',
            [
                'vehicle'  => $vehicle,
                'canView'  => $canView,
                'carMakes' => $carMakes
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function dvlaLookup(Request $request): JsonResponse
    {
        $request->validate([
            'reg_no' => 'required',
        ], [
            'reg_no.required' => 'The Vehicle registration number is required.',
        ]);
        $vehicle = $this->vehicleService->dvlaLookupByVehicleReg($request->get('reg_no'));

        return Response::json($vehicle);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getCarModel($id): JsonResponse
    {
        $cardModels = $this->vehicleService->getCarModelsByField('make_id', [$id]);

        return Response::json($cardModels);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getVehiclePayload(Request $request): array
    {
        $payload = $request->all();
        $payload['user_id'] = $request->user()->id;
        $payload['sale'] = $request->get('sale') === 'on' ? 1 : 0;
        $payload['model_id'] = $request->get('model_id') != '---' ? $request->get('model_id') : null;
        $payload['make_id'] = $request->get('make_id') != '---' ? $request->get('make_id') : null;

        return $payload;
    }

    public function getWhatWindScreenLookUpById($id)
    {
       $response = $this->whatWindscreenApiService->getById($id);
       dd($response);
    }
    public function createWhatWindscreenLookup(CreateWhatWindscreenLookupRequest $request)
    {
       return  $this->whatWindscreenApiService->create($request);
    }
}
