<?php

namespace App\Http\Controllers;

use App\Helpers\BasicHelpers;
use App\Helpers\BladeHelpers;
use App\Helpers\StaticMessages;
use App\Models\VehicleHistory;
use App\Services\BookingService;
use App\Services\CommunicationService;
use App\Services\CustomerService;
use App\Services\HolidayService;
use App\Services\UserService;
use App\Services\VehicleService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var VehicleService
     */
    private $vehicleService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var HolidayService
     */
    private $holidayService;

    /**
     * @var CommunicationService
     */
    private $communicationService;

    /**
     * Create a new controller instance.
     *
     * @param BookingService $bookingService
     * @param CustomerService $customerService
     * @param VehicleService $vehicleService
     * @param UserService $userService
     * @param HolidayService $holidayService
     * @param CommunicationService $communicationService
     */
    public function __construct(
        BookingService $bookingService,
        CustomerService $customerService,
        VehicleService $vehicleService,
        UserService $userService,
        HolidayService $holidayService,
        CommunicationService $communicationService
    ) {
        $this->bookingService = $bookingService;
        $this->customerService = $customerService;
        $this->vehicleService = $vehicleService;
        $this->userService = $userService;
        $this->holidayService = $holidayService;
        $this->communicationService = $communicationService;
    }

    /**
     * Show the Local page.
     *
     * @param string $type
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function calendar(string $type, Request $request)
    {
        $staffHolidays = [];
        $bankHolidays = [];

        if ($request->isMethod('post')) {
            $date = $request->get('date');

            return view(
                'booking.index',
                [
                    'date' => $date,
                    'type' => $type
                ]
            );
        }

        $bookings = $this->getBookings($request, $type);

        if ($request->has('start')) {
            $staffHolidays = $this->holidayService->getStaffHolidays(
                [
                    'date_from' => $request->query('start'),
                    'date_to'   => $request->query('end')
                ]
            );

            $bankHolidays = $this->holidayService->getBankHolidays(
                [
                    'date_from' => $request->query('start'),
                    'date_to'   => $request->query('end')
                ]
            );
        }

        if (count($bookings) > 0) {
            return response()->json(
                array_merge(
                    BladeHelpers::showBankHolidays($bankHolidays),
                    BladeHelpers::showStaffHolidays($staffHolidays),
                    BladeHelpers::convertData($bookings)
                )
            );
        }

        $unallocatedBookingsData = $this->getUnallocatedBookings($type);
        $unallocatedBookings = BladeHelpers::convertData($unallocatedBookingsData);

        return view(
            'booking.index',
            [
                'date'                => '',
                'type'                => $type,
                'unallocatedBookings' => $unallocatedBookings
            ]
        );
    }

    /**
     * Show the AllBookings page.
     *
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function allBookings(Request $request)
    {
        if ($request->ajax()) {
            $this->processRequest($request);

            $totalRecords = $this->bookingService->getVehicleHistoriesCount();
            $totalRecordsWithFilter = $this->bookingService->getVehicleHistoriesCount($this->searchValue);

            $vehicleHistories = $this->bookingService->getVehicleHistoriesPaginator(
                $this->columnName,
                'desc',
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($vehicleHistories as $item) {
                $results[] = [
                    'id'            => $item->id,
                    'date_added'    => date('Y-m-d', strtotime($item->date_added)),
                    'datetime'      => date('Y-m-d', strtotime($item->datetime)),
                    'reg_no'        => $item->vehicle->reg_no,
                    'company_name'  => $item->company ? $item->company->name : "",
                    'customer_name' => $item->company ? $item->customer->first_name . " " . $item->customer->surname : "",
                    'address_1'     => $item->customer->address_1,
                    'postcode'      => $item->customer->postcode,
                    'booked_by'     => $item->addedBy ? $item->addedBy->first_name . " " . $item->addedBy->surname : "",
                    'status'        => "<p style='border-radius: 2px; color: white; background-color: {$item->statusColor()}; text-align: center;'>$item->statusText</p>",
                    'is_invoiced'   => $item->invoice_type == "invoice" ? "Invoiced" : "",
                    'view'          => "<a class='list-inline-item'>
                                <button class='btn btn-success btn-sm rounded-0 view-booking' id='$item->id' type='button'
                                        data-toggle='tooltip'
                                        data-placement='top' title='View'><i class='fa fa-eye'></i></button>
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

        return view('booking/all');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make(
            $data,
            [
                'status'       => ['required', 'numeric'],
                'calendar'     => ['required', 'string'],
                'company_name' => ['required'],
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveBooking(Request $request): JsonResponse
    {
        /*$validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->with(['message', $validator->errors()->first(), 'alert-type' => 'error']);
        }*/

        $account = Auth::user();
        $payload = $this->customerPayload($request);

        if ($request->get('vehicle_history_id') !== null) {
            $vehicleHistory = $this->bookingService->getVehicleHistoryById($request['vehicle_history_id']);
            $this->vehicleService->updateVehicle($payload, $vehicleHistory->vehicle_id);

            if (isset($payload)) {
                $this->customerService->updateCustomer($vehicleHistory->customer_id, $payload);
            }

            $payload = $request->all();
            $data = array_merge(
                $payload,
                [
                    'customer_id' => $vehicleHistory->customer_id,
                    'vehicle_id'  => $vehicleHistory->vehicle_id,
                    'vehicle_reg'  => $payload['vehicle_registration_number']
                ]
            );

            $data['type'] = "jobcard";

            if ($data['datetime'] !== "1970-01-01") {
                $data['datetime'] = !empty($data['datetime']) ? date('Y-m-d 09:00:00', strtotime($data['datetime'])) : null;
            } else {
                $data['datetime'] = null;
            }

            $vehicleHistory = $this->bookingService->updateBooking($data, $vehicleHistory->id);
            $this->jobCardItemUpdate($vehicleHistory->id, $payload);
            $this->saveEmailText($request, $data, $account, $vehicleHistory);

            return response()->json(
                [
                    'id'         => $vehicleHistory->id,
                    'message'    => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]
            );
        } else {
            $customer = $this->customerService->createCustomer($payload);
            $vehicle = $this->vehicleService->createVehicle($payload);
            $this->customerGroupRelate($request, $customer->id, $this->customerService);

            $data = array_merge(
                $payload,
                [
                    'customer_id' => $customer->id,
                    'vehicle_id'  => $vehicle->id
                ]
            );

            $data['type'] = "jobcard";

            if ($data['datetime'] !== "1970-01-01") {
                $data['datetime'] = !empty($data['datetime']) ? date('Y-m-d 09:00:00', strtotime($data['datetime'])) : null;
            } else {
                $data['datetime'] = null;
            }

            $vehicleHistory = $this->bookingService->createBooking($data);
            $this->jobCardItem($vehicleHistory->id, $payload);
            $this->saveEmailText($request, $data, $account, $vehicleHistory);

            return response()->json(
                [
                    'id'         => $vehicleHistory->id,
                    'message'    => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]
            );
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function checkDateQuery(Request $request): bool
    {
        return $request->query->count() > 0;
    }

    /**
     * @param Request $request
     * @param string $booking
     * @return VehicleHistory[]|array|Builder[]|Collection
     */
    private function getBookings(Request $request, string $booking)
    {
        if ($this->checkDateQuery($request)) {
            $start = date('Y/m/d', Carbon::make($request->query('start'))->getTimestamp());
            $end = date('Y/m/d', Carbon::make($request->query('end'))->getTimestamp());

            return $this->bookingService->getVehicleHistoryByWeek($booking, $start, $end);
        }

        return [];
    }

    /**
     * @return VehicleHistory[]|array|Builder[]|Collection
     */
    private function getUnallocatedBookings()
    {
        return $this->bookingService->getAllUnallocatedVehicleHistories();
    }

    /**
     * @param $id
     * @param array $payload
     * @return void
     */
    private function jobCardItem($id, array $payload)
    {
        foreach ($payload['invoice_row_id'] as $k => $invoices) {
            $this->bookingService->createJobCardItem(
                array_merge(
                    $payload,
                    [
                        'history_id'  => $id,
                        'type'        => $payload['type'][$k],
                        'description' => $payload['description'][$k],
                        'qty'         => $payload['qty'][$k],
                        'cost_price'  => $payload['cost_price'][$k],
                        'sell_price'  => $payload['sell_price'][$k],
                    ]
                )
            );
        }
    }

    /**
     * @param $id
     * @param array $payload
     * @return void
     */
    public function jobCardItemUpdate($id, array $payload)
    {
        foreach ($payload['invoice_row_id'] as $k => $invoices) {
            $this->bookingService->updateJobCardItem(
                [
                    'history_id'  => $id,
                    'type'        => $payload['type'][$k],
                    'description' => $payload['description'][$k],
                    'qty'         => $payload['qty'][$k],
                    'cost_price'  => $payload['cost_price'][$k],
                    'sell_price'  => $payload['sell_price'][$k],
                ],
                $id
            );
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findBooking(int $id)
    {
        return $this->bookingService->getVehicleHistory($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function removeBooking(int $id)
    {
        return $this->bookingService->removeBooking($id);
    }

    /**
     * @param string $calendar
     * @param int $id
     * @param string $date
     * @return mixed
     */
    public function changeBookingDate(string $calendar, int $id, string $date)
    {
        if ($date !== "null") {
            $date = date('Y-m-d H:i:s', strtotime($date));
        } else {
            $date = null;
        }

        return $this->bookingService->updateBooking(['calendar' => $calendar, 'datetime' => $date], $id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function signatureSave(Request $request)
    {
        return $this->bookingService->saveSignature($request);
    }

    /**
     * @param $date
     * @return Application|Factory|View
     */
    public function technicianView($date = null)
    {
        $selectedDate = date('Y-m-d');

        if ($date) {
            $selectedDate = $date;
        }

        $technicians = $this->userService->getTechnicians();

        return view('technician.view', compact('technicians', 'selectedDate'));
    }

    public function previousDate($date)
    {
        $newDate = $this->getDate($date, "previous");

        return redirect('/technician/view/' . $newDate);
    }

    /**
     * @param $date
     * @return Application|RedirectResponse|Redirector
     */

    public function nextDate($date)
    {
        $newDate = $this->getDate($date);

        return redirect('/technician/view/' . $newDate);
    }

    /**
     * @param $date
     * @param $condition
     * @return false|string
     */
    public function getDate($date, $condition = null)
    {
        $day = '+1 day';
        if ($condition == 'previous') {
            $day = '-1 day';
        }

        return date("Y-m-d", strtotime($day, strtotime($date)));
    }

    /**
     * @return Application|Factory|View
     */
    public function technicianBookings()
    {
        $todayBookings = $this->bookingService->getTechnicianBookingsByDate(auth()->user()->id, Carbon::today());
        return view('technician.bookings', compact('todayBookings'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateTechnicianBooking(Request $request)
    {
        return $this->bookingService->updateTechnicianVehicleHistory($request);
    }

    /**
     * @param $request
     * @param $data
     * @param $account
     * @param $vehicleHistory
     */
    private function saveEmailText($request, $data, $account, $vehicleHistory)
    {
        if ($request->get('send_email') == 1) {
            $message = trim(
                BasicHelpers::messageReplace(
                    $account->msg_booking_instant,
                    $vehicleHistory->vehicle->reg_no,
                    date('d/m/Y', strtotime($data['datetime']))
                )
            );

            $subject = trim('Your ' . $account->tag_vehicle . ' Booking ');

            $this->communicationService->sendMail(
                $vehicleHistory->customer_id,
                $vehicleHistory->vehicle_id,
                $subject,
                'instant',
                $message
            );
        }

        if ($request->get('send_text') == 1) {
            $message = trim(
                BasicHelpers::messageReplace(
                    $account->msg_booking_instant,
                    $vehicleHistory->vehicle->reg_no,
                    date('d/m/Y', strtotime($data['datetime']))
                )
            );

            $this->communicationService->sendSMS(
                $vehicleHistory->customer_id,
                $vehicleHistory->vehicle_id,
                'instant',
                $message
            );
        }
    }
}
