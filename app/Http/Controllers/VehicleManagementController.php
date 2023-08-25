<?php

namespace App\Http\Controllers;

use App\Helpers\BasicHelpers;
use App\Helpers\StaticMessages;
use App\Services\VehicleManagementService;
use Carbon\Carbon;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class VehicleManagementController extends Controller
{
    /**
     * @var VehicleManagementService
     */
    private $vehicleManagementService;

    /**
     * Create a new controller instance.
     *
     * @param VehicleManagementService $vehicleManagementService
     */
    public function __construct(VehicleManagementService $vehicleManagementService)
    {
        $this->vehicleManagementService = $vehicleManagementService;
    }

    /**
     * Show the VehicleManagement page.
     *
     * @return Application|Factory|View
     */
    public function vehicleManagement()
    {
        $dates = $this->getStartEndDates();

        $vehicleManagements = $this->vehicleManagementService
            ->getVehicleManagementDue($dates[0], $dates[1]);
        $vehicleManagementsOverDue = $this->vehicleManagementService
            ->getVehicleManagementOverDue($dates[0]);

        return view('vehicle-management.management.index', [
            'vehicleManagements' => $vehicleManagements,
            'vehicleManagementsOverDue' => $vehicleManagementsOverDue
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newVehicleManagement(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->vehicleManagementService
                ->createVehicleManagement($request->all());

            return redirect()->route('vehicle-management')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('vehicle-management.management.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editManagement(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->vehicleManagementService->updateVehicleManagement($id, $request->all());

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $vehicleManagement = $this->vehicleManagementService->getVehicleManagementById($id);

        return view('vehicle-management.management.edit', [
            'vehicleManagement' => $vehicleManagement,
        ]);
    }

    /**
     * Show the VehicleManagement page.
     *
     * @return Application|Factory|View
     */
    public function vehicleMaintenance()
    {
        $vehicleManagements = $this->vehicleManagementService
            ->getVehicleManagements();

        return view('vehicle-management.maintenance.index', [
            'vehicleManagements' => $vehicleManagements
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function vehicleEvent()
    {
        $dates = $this->getStartEndDates();

        $vehicleEvents = $this->vehicleManagementService
            ->getVehicleEventsDue($dates[0], $dates[1]);
        $vehicleEventsOverDue = $this->vehicleManagementService
            ->getVehicleEventsOverDue($dates[0]);

        return view('vehicle-management.event.index', [
            'vehicleEvents' => $vehicleEvents,
            'vehicleEventsOverDue' => $vehicleEventsOverDue
        ]);
    }

    /**
     * @return array
     */
    private function getStartEndDates(): array
    {
        $start = date('Y/m/d', strtotime(Carbon::now()));
        $end = date('Y/m/d', strtotime('+1 month', strtotime($start)));

        return [$start, $end];
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function vehicleEventEdit(Request $request, $id)
    {
        $eventCompleted = 0;
        if ($request->isMethod('put')) {
            if (isset($request->event_completed)) {
                $eventCompleted = 1;
            }

            $payload = $this->vehicleMaintenanceEventPayload($request);
            unset($payload['file_name']);
            unset($payload['_token']);
            unset($payload['_method']);
            $this->vehicleManagementService->updateVehicleEvent(array_merge($payload,[
                'event_completed' => $eventCompleted
            ]), $id);
            if ($request->hasFile('file_name')) {
                $this->vehicleEventAttachment($request, $id);

            }

            return redirect()->route('vehicle-event')
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_INFO,
                ]);
        }

        $vehicleMaintenanceEvent = $this->vehicleManagementService->getVehicleEventById($id);

        return view('vehicle-management.event.edit', [
            'vehicleMaintenanceEvent' => $vehicleMaintenanceEvent,
        ]);
    }

    public function vehicleMaintenanceEventPayload($request)
    {
        $payload = $request->all();
        $payload['vehicle_maintenance_id'] = $request->vehicle_event_maintenance_id;
        $payload['start_date'] = $request->start_date;
        $payload['end_date'] = $request->end_date;
        $payload['schedule_type'] = $request->schedule_type;
        $payload['service_type'] = $request->service_type;
        $payload['note'] = $request->note;
        $payload['cost'] = $request->cost;
        $payload['invoice_ref'] = $request->invoice_ref;
        $payload['event_completed'] = $request->event_completed;
        $payload['status'] = $request->status;

        return $payload;
    }

    /**
     * @param $request
     * @param $id
     * @return void|null
     */
    public function vehicleEventAttachment($request, $id)
    {
        $attachments = $this->vehicleManagementService->findAttachment($id);
        if (!$attachments) {
            foreach ($request->file_name as $attachment) {
                $request['file_name'] = BasicHelpers::upload($request, 'file_name', 'upload/event-attachments/');
                $request['vehicle_maintenance_event_id'] = $id;

                $this->vehicleManagementService->addVehicleEventAttachment($request);
            }
        } else {
            foreach($attachments as $attachment) {

                File::delete('upload/event-attachments/'.$attachment->file_name);

                $request['file_name'] = BasicHelpers::upload($request, 'file_name', 'upload/event-attachments/');
                $request['vehicle_maintenance_event_id'] = $id;

                return $this->vehicleManagementService->updateVehicleEventAttachment($request, $id);
            }
        }
    }
}
