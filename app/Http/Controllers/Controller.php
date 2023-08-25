<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    protected $draw;

    /**
     * @var string
     */
    protected $searchValue;

    /**
     * @var string
     */
    protected $columnName;

    /**
     * @var string
     */
    protected $columnSortOrder;

    /**
     * @var string
     */
    protected $start;

    /**
     * @var string
     */
    protected $rowPerPage;

    /**
     * @param Request $request
     * @return void
     */
    protected function processRequest(Request $request)
    {
        # Read value
        $this->draw = $request->get('draw');
        $this->start = $request->get("start");
        $this->rowPerPage = $request->get("length"); // Rows display per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $this->columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $this->columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $this->searchValue = $search_arr['value']; // Search value
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function customerPayload(Request $request): array
    {
        $payload = $request->all();
        $payload['send_email']          = (int)($request->get('send_email') === 'on');
        $payload['send_text']           = (int)($request->get('send_text') === 'on');
        $payload['invoice_type']        = (int)($request->get('invoice_type') === 'on');
        $payload['warranty_work']       = (int)($request->get('warranty_work') === 'on');
        $payload['cust_account']       = (int)($request->get('cust_account') === 'on');
        $payload['calibration']         = (int)($request->get('calibration') === 'on');
        $payload['notes']               = trim($request->get('notes'));
        $payload['job_cost']            = trim($request->get('job_cost'));
        $payload['work_required']       = trim($request->get('work_required'));
        $payload['additional_details']  = trim($request->get('additional_details'));
        $payload['tech_details']        = trim($request->get('tech_details'));
        $payload['company_name']        = $request->get('company_name') !== "-- select --" ? $request->get('company_name') : NULL;
        $payload['sub_contractor']      = $request->get('sub_contractor') !== "-- select --" ? $request->get('sub_contractor') : NULL;
        $payload['glass_supplier']      = $request->get('glass_supplier') !== "-- select --" ? $request->get('glass_supplier') : NULL;
        $payload['technician']          = $request->get('technician') !== "-- select --" ? $request->get('technician') : NULL;
        $payload['make_id']          = $request->get('make_id') !== "-- select --" ? $request->get('make_id') : NULL;
        $payload['model_id']          = $request->get('model_id') !== "-- select --" ? $request->get('model_id') : NULL;
        $payload['vehicle_reg']         = trim($request->get('vehicle_registration_number'));
        $payload['vin_number']          = trim($request->get('vin_number'));

        return $payload;
    }

    /**
     * @param Request $request
     * @param $id
     * @param $customerService
     * @return void
     */
    protected function customerGroupRelate(Request $request, $id, $customerService)
    {
        for ($i = 1; $i <= $customerService->groupsCount(); $i++) {
            if ($request->get('group_id' . $i) !== null) {
                $customerService->setCustomerGroup(
                    $id,
                    $request->get('group_id' . $i),
                    $request->user()->id
                );
            }
        }
    }
}
