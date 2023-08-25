<?php

namespace App\View\Components;

use App\Services\AdminService;
use App\Services\CustomerService;
use App\Services\UserService;
use App\Services\VehicleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TechnicianBookingModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        CustomerService $customerService,
        VehicleService $vehicleService,
        AdminService $adminService,
        UserService $userService
    ) {
        $this->customerService = $customerService;
        $this->vehicleService = $vehicleService;
        $this->adminService = $adminService;
        $this->userService = $userService;

        $this->calendarTypes = [
            (object)[
                'id'   => 'local',
                'name' => 'Local'
            ],
            (object)[
                'id'   => 'national',
                'name' => 'National'
            ],
            (object)[
                'id'   => 'zenith',
                'name' => 'Zenith'
            ],
            (object)[
                'id'   => 'aac',
                'name' => 'AAC Insurance'
            ],
            (object)[
                'id'   => 'autoglass',
                'name' => 'Auto glass Jobs'
            ],
            (object)[
                'id'   => 'academy',
                'name' => 'Academy'
            ],
            (object)[
                'id'   => 'quote',
                'name' => 'Quote'
            ],
            (object)[
                'id'   => 'wlocal',
                'name' => 'Warranty Local'
            ],
            (object)[
                'id'   => 'wnational',
                'name' => 'Warranty National'
            ],
        ];

        $this->customerTitles = [
            (object)[
                'id'   => 'Mr',
                'name' => 'Mr'
            ],
            (object)[
                'id'   => 'Mrs',
                'name' => 'Mrs'
            ],
            (object)[
                'id'   => 'Miss',
                'name' => 'Miss'
            ],
            (object)[
                'id'   => 'Ms',
                'name' => 'Ms'
            ],
            (object)[
                'id'   => 'Sir',
                'name' => 'Sir'
            ],
            (object)[
                'id'   => 'Dame',
                'name' => 'Dame'
            ],
            (object)[
                'id'   => 'Dr',
                'name' => 'Dr'
            ],
            (object)[
                'id'   => 'Cllr',
                'name' => 'Cllr'
            ],
            (object)[
                'id'   => 'Lady',
                'name' => 'Lady'
            ],
            (object)[
                'id'   => 'Lord',
                'name' => 'Lord'
            ],
        ];

        $this->cardItemTypes = [
            (object)[
                'id'   => 'blank',
                'name' => '--Blank Row--'
            ],
            (object)[
                'id'   => 'labour_fixed',
                'name' => 'Labour (Fixed) Row'
            ],
            (object)[
                'id'   => 'parts_labour_fixed',
                'name' => 'Parts/Labour (Fixed) Row'
            ],
            (object)[
                'id'   => 'labour',
                'name' => 'Labour Row'
            ],
            (object)[
                'id'   => 'parts_fixed',
                'name' => 'Parts (Fixed) Row'
            ],
            (object)[
                'id'   => 'parts',
                'name' => 'Parts Row'
            ],
            (object)[
                'id'   => 'recovery',
                'name' => 'Recovery Row'
            ],
            (object)[
                'id'   => 'misc',
                'name' => 'Misc Row'
            ],
            (object)[
                'id'   => 'discount',
                'name' => 'Discount'
            ],
        ];

        $this->paymentTypes = [
            (object)[
                'id'   => '',
                'name' => 'Select Payment Type'
            ],
            (object)[
                'id'   => 'card',
                'name' => 'Card'
            ],
            (object)[
                'id'   => 'cash',
                'name' => 'Cash'
            ],
            (object)[
                'id'   => 'cheque',
                'name' => 'Cheque'
            ],
        ];

        $this->jobNotCompletedReasons = [
            (object)[
                'id'   => '',
                'name' => 'Select Reason'
            ],
            (object)[
                'id'   => 'bad_weather',
                'name' => 'Bad Weather'
            ],
            (object)[
                'id'   => 'wrong_glass_supplied',
                'name' => 'Wrong Glass Supplied'
            ],
            (object)[
                'id'   => 'customer_unavailable',
                'name' => 'Customer Unavailable'
            ],
            (object)[
                'id'   => 'wrong_address',
                'name' => 'Wrong Address'
            ],
        ];

        $this->jobStatuses = [
            (object)[
                'id'   => 1,
                'name' => 'Pending'
            ],
            (object)[
                'id'   => 2,
                'name' => 'In Progress'
            ],
            (object)[
                'id'   => 3,
                'name' => 'Job Completed'
            ],
            (object)[
                'id'   => 4,
                'name' => 'Awaiting Auth'
            ],
            (object)[
                'id'   => 5,
                'name' => 'Awaiting Parts'
            ],
            (object)[
                'id'   => 6,
                'name' => 'Priority'
            ],
            (object)[
                'id'   => 7,
                'name' => 'Invoiced'
            ],
            (object)[
                'id'   => 8,
                'name' => 'Cancelled'
            ],
            (object)[
                'id'   => 9,
                'name' => 'Quote'
            ],
        ];
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $companies = $this->customerService->getCompaniesName();
        //$customers = $this->customerService->getAllCustomers();
        $carMakes = $this->vehicleService->getCarMakes(['id', 'name']);
        //$carModels = $this->vehicleService->getCarModelsByMakeId(['id', 'name']);
        $subContractors = $this->adminService->getSubContractors();
        $groups = $this->customerService->getGroups(['id', 'name']);
        $glassSuppliers = $this->customerService->getGlassSuppliers(['id', 'name']);
        $technicians = $this->userService->getTechnicians();

        return view(
            'components.technician-booking-modal',
            [
                'companies'              => $companies,
                'carMakes'               => $carMakes,
                'carModels'              => [],
                'subContractors'         => $subContractors,
                'groups'                 => $groups,
                'glassSuppliers'         => $glassSuppliers,
                'technicians'            => $technicians,
                'customers'              => [],
                'calendarTypes'          => $this->calendarTypes,
                'cardItemTypes'          => $this->cardItemTypes,
                'customerTitles'         => $this->customerTitles,
                'paymentTypes'           => $this->paymentTypes,
                'jobNotCompletedReasons' => $this->jobNotCompletedReasons,
                'jobStatuses'            => $this->jobStatuses,
            ]
        );
    }

}
