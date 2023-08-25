<?php

namespace App\Http\Controllers\API;

use App\Helpers\BasicHelpers;
use App\Http\Controllers\Controller;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * Create a new controller instance.
     *
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bookings(Request $request): JsonResponse
    {
        $results = [];
        $vehicleHistories = $request->user()->vehicleHistories;

        foreach ($vehicleHistories as $k => $vehicleHistory) {
            $results[] = $vehicleHistory->toArray();
            $results[$k]['vehicle'] = $vehicleHistory->vehicle;
            $results[$k]['customer'] = $vehicleHistory->customer;
            $results[$k]['glass_supplier'] = $vehicleHistory->glassSupplier;
            $results[$k]['sub_contractor'] = $vehicleHistory->subContractor;

            unset($results[$k]['vehicle_id']);
            unset($results[$k]['customer_id']);
        }

        return sendApiResponse($results, 'success');
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
            'image' => ['required', 'file'],
            'name'  => ['required', 'string'],
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function addSign(Request $request, $id): JsonResponse
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return sendApiError('Invalid request', $validator->errors()->toArray(), 400);
        }

        if (!$request->file('image')->isValid()) {
            return sendApiError('Invalid file', [], 400);
        }

        $filename = BasicHelpers::upload($request);

        $docs = $this->bookingService->newVehicleHistoryDocs([
            'history_id' => $id,
            'name' => $request->get('name'),
            'filename' => $filename
        ]);

        return sendApiResponse($docs->toArray(), 'success');
    }

    /**
     * Show the application dashboard.
     *
     * @param $id
     * @return JsonResponse
     */
    public function booking($id): JsonResponse
    {
        $vehicleHistory = $this->bookingService->getVehicleHistoryById($id);

        if (!$vehicleHistory) {
            return sendApiResponse([], 'success');
        }

        $vehicle = $vehicleHistory->vehicle;

        if ($vehicle) {
            $vehicle->carMake;
            $vehicle->carModel;
        }

        $result = array_merge($vehicleHistory->toArray(), [
            'company' => $vehicleHistory->company,
            'customer' => $vehicleHistory->customer,
            'glassSupplier' => $vehicleHistory->glassSupplier,
            'vehicle' => $vehicleHistory->vehicle,
            'subContractor' => $vehicleHistory->subContractor,
            'items' => $vehicleHistory->items,
            'groups' => $vehicleHistory->groups,
            'technician' => $vehicleHistory->technician,
            'tech1' => $vehicleHistory->technicianOne,
            'tech2' => $vehicleHistory->technicianTwo,
            'tech3' => $vehicleHistory->technicianThree,
        ]);

        return sendApiResponse($result, 'success');
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateBooking(Request $request, $id): JsonResponse
    {
        $booking = $this->bookingService->updateVehicleHistory($request->all(), $id);

        return sendApiResponse($booking->toArray(), 'Updated successfully');
    }


}
