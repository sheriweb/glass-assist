<?php

namespace App\Http\Controllers;

use App\Helpers\StaticMessages;
use App\Services\ArchiveService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * @var ArchiveService
     */
    private $archiveService;

    /**
     * Create a new controller instance.
     *
     * @param ArchiveService $archiveService
     */
    public function __construct(ArchiveService $archiveService)
    {
        $this->archiveService = $archiveService;
    }

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|View
     */
    public function customers()
    {
        $customers = $this->archiveService->getArchivedCustomers();

        return view('archive.customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function unarchiveCustomer($id): RedirectResponse
    {
        $this->archiveService->unarchiveCustomer($id);

        return redirect()->back()
            ->with([
                'message' => StaticMessages::$UNARCHIVE,
                'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
            ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function categories()
    {
        $categories = $this->archiveService->getCategories();

        return view('archive.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function unarchiveCategories($id): RedirectResponse
    {
        $this->archiveService->unarchiveCategory($id);

        return redirect()->back()
            ->with([
                'message' => StaticMessages::$UNARCHIVE,
                'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
            ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function assets()
    {
        $assets = $this->archiveService->getArchivedAssets();

        return view('archive.assets.index', [
            'assets' => $assets
        ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function unarchiveAssets($id): RedirectResponse
    {
        $this->archiveService->unarchiveAsset($id);

        return redirect()->back()
            ->with([
                'message' => StaticMessages::$UNARCHIVE,
                'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
            ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function vehicles()
    {
        $vehicles = $this->archiveService->getVehicles(['vehicles.status' => 0]);

        return view('archive.vehicles.index', [
            'vehicles' => $vehicles
        ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function unarchiveVehicle($id): RedirectResponse
    {
        $this->archiveService->unarchiveVehicle($id);

        return redirect()->back()
            ->with(['message' => 'Unarchived successfully', 'alert-type' => 'success']);
    }

    /**
     * @return Application|Factory|View
     */
    public function groups(Request $request)
    {
        $groups = $this->archiveService->getGroups($request->user()->id);

        return view('archive.groups.index', [
            'groups' => $groups
        ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function unarchiveGroup($id): RedirectResponse
    {
        $this->archiveService->unarchiveGroup($id);

        return redirect()->back()
            ->with([
                'message' => StaticMessages::$UNARCHIVE,
                'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
            ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function vehicleMaintenanceEvents()
    {
        $events = $this->archiveService->getVehicleMaintenanceEvents();

        return view('archive.vehicle-maintenance-events.index', [
            'events' => $events
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function editVehicleMaintenanceEvent(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $this->archiveService->updateVehicleMaintenanceEvent($id, $request->all());

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $event = $this->archiveService->getVehicleMaintenanceEvent($id);

        return view('archive.vehicle-maintenance-events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function unarchiveVehicleMaintenanceEvent($id): RedirectResponse
    {
        $this->archiveService->unarchiveVehicleMaintenanceEvent($id);

        return redirect()->back()
            ->with([
                'message' => StaticMessages::$UNARCHIVE,
                'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
            ]);
    }
}
