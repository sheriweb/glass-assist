<?php

namespace App\Http\Controllers;

use App\Models\VehicleHistory;
use App\Services\CommunicationService;
use App\Services\PDFService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use MYPDF;
use TCPDF;

class PDFController extends Controller
{
    private $account;

    /**
     * @var PDFService
     */
    private $pdfService;

    /**
     * @var CommunicationService
     */
    private $communicationService;

    /**
     * Create a new controller instance.
     *
     * @param PDFService $pdfService
     * @param CommunicationService $communicationService
     */
    public function __construct(PDFService $pdfService, CommunicationService $communicationService)
    {
        $this->pdfService = $pdfService;
        $this->communicationService = $communicationService;
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function generatePDF(Request $request)
    {
        if ($request->query('order_id')) {
            $order = $this->pdfService->getOrder($request->query('order_id'));

            return Pdf::loadView(
                'pdf.invoice',
                [
                    'order' => $order
                ]
            )->stream("{$request->user()->username}.pdf");
        }

        return redirect()->back();
    }

    public function jobCard($vehicleHistoryId)
    {
        if ($vehicleHistoryId) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(0);
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('Helvetica', '', 10, '', true);
            $pdf->AddPage();

            $html = $this->getJobCardHtml($vehicleHistoryId, 1);
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            $pdf->Output('jobcard_' . $vehicleHistoryId . '.pdf', 'I');
        }
    }

    public function jobCardSubscription($vehicleHistoryId)
    {
        if ($vehicleHistoryId) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(0);
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('Helvetica', '', 10, '', true);
            $pdf->AddPage();

            $html = $this->getSubJobCardHtml($vehicleHistoryId, 1);
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

            $pdf->Output('jobcard_' . $vehicleHistoryId . '_subc.pdf', 'I');
        }
    }

    public function emailJobCardSubscription($vehicleHistoryId)
    {
        if ($vehicleHistoryId) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(0);

            $pdf->setFontSubsetting(true);

            $pdf->SetFont('Helvetica', '', 10, '', true);

            $pdf->AddPage();

            $html = $this->getSubJobCardHtml($vehicleHistoryId, 1);

            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

            $vehicleHistory = VehicleHistory::query()->findOrFail($vehicleHistoryId);
            $vehicle = $vehicleHistory->vehicle;
            $subContractor = $vehicleHistory->subContractor;
            $filename = 'jobcard_' . $vehicleHistoryId . '_subc.pdf';
            $fileArray = ['filestring' => $pdf->Output($filename, 'S'), 'filename' => $filename];
            $filename = $fileArray['filename'];
            $fileString = $fileArray['filestring'];

            $body = '<p>PLEASE FIND JOB CARD ATTACHED</p>
                    <p>Glass Assist UK Ltd<br/>
                    Whitfield House<br/>
                    St John\'s Rd<br/>
                    Meadowfield<br/>
                    Durham<br/>
                    DH7 8XL</p>
                    <p>Phone: 01913784979</p>
                    <p>Email: sales@glassassistuk.co.uk</p>';

            $sendArr = [
                'subject'    => 'Job Card for ' . $vehicle->reg_no,
                'body'       => $body,
                'filestring' => $fileString,
                'filename'   => $filename
            ];

            if (!empty($subContractor->email1)) {
                $sendArr['to'] = $subContractor->email1;
                $this->sendJobCardSubscriptionEmail($vehicleHistoryId, $subContractor->email1);
            }

            if (!empty($subContractor->email2)) {
                $sendArr['to'] = $subContractor->email2;
                $this->sendJobCardSubscriptionEmail($vehicleHistoryId, $subContractor->email2);
            }

            if (!empty($subContractor->email3)) {
                $sendArr['to'] = $subContractor->email3;
                $this->sendJobCardSubscriptionEmail($vehicleHistoryId, $subContractor->email3);
            }

            if (!empty($vehicleHistory->manual_email)) {
                $sendArr['to'] = $vehicleHistory->manual_email;
                $this->sendJobCardSubscriptionEmail($vehicleHistoryId, $vehicleHistory->manual_email);
            }

            $this->communicationService->sendMailViaSMTP($sendArr);
            $this->communicationService->recordSent(
                'email',
                'subc',
                1,
                0,
                0,
                $sendArr['to'],
                $sendArr['subject'],
                $sendArr['body']
            );

            $response = [
                'success' => true,
                'message' => "PDF File Sent",
            ];

            return response()->json($response);
        }
    }

    /**
     * @param int $vehicleHistoryId
     * @param string $email
     */
    public function sendJobCardSubscriptionEmail(int $vehicleHistoryId, string $email)
    {
        if (isset($vehicleHistoryId)) {
            $account = auth()->user();
            $vehicleHistory = VehicleHistory::query()->findOrFail($vehicleHistoryId);
            $vehicle = $vehicleHistory->vehicle;
            $customer = $vehicleHistory->customer;

            $makeAndModel = $vehicle->carMake->name . ' ' . $vehicle->carModel->name;

            if (strlen($makeAndModel) > 25) {
                $makeAndModel = substr($makeAndModel, 0, 25);
            }
            if (trim($makeAndModel) == '') {
                $makeAndModel = $vehicleHistory->manual_make_model;
            }

            $datetime = date("l d/m/Y H:i", strtotime($vehicleHistory->datetime));
            $timeAllocatedArray = explode(':', $vehicleHistory->time_allocated);
            $seconds = ($timeAllocatedArray[0] * 60 * 60) + ($timeAllocatedArray[1] * 60);
            $endTime = date('H:i', (strtotime($vehicleHistory->datetime) + $seconds));

            $body = $vehicleHistory->id . "\r\n\r\n";
            $body .= $datetime . " - " . $endTime . "\r\n\r\n";
            $body .= 'Customer' . "\r\n\r\n";
            $body .= $customer->title ? $customer->title . "\r\n\r\n" : "";
            $body .= $customer->first_name . " " . $customer->surname . "\r\n\r\n";
            $body .= $customer->address_1 ? $customer->address_1 . "\r\n\r\n" : "";
            $body .= $customer->address_2 ? $customer->address_2 . "\r\n\r\n" : "";
            $body .= $customer->city ? $customer->city . "\r\n\r\n" : "";
            $body .= $customer->postcode ? $customer->postcode . "\r\n\r\n" : "";
            $body .= $customer->phone ? $customer->phone . "\r\n\r\n" : "";
            $body .= $customer->mobile ? $customer->mobile . "\r\n\r\n" : "";
            $body .= 'Vehicle Reg: ' . $vehicle->reg_no . "\r\n\r\n";
            $body .= 'VIN Number: ' . $vehicle->vin_number . "\r\n\r\n";
            $body .= 'Make & Model: ' . $makeAndModel . "\r\n\r\n";
            $body .= 'Mileage: ' . $vehicleHistory->mileage . "\r\n\r\n";
            $body .= 'Work Required: ' . $vehicleHistory->work_required . "\r\n\r\n";
            $body .= 'Additional Details: ' . $vehicleHistory->additional_details . "\r\n\r\n";
            $body .= 'Glass Assist UK Ltd' . "\r\n\r\n";
            $body .= 'Whitfield House' . "\r\n\r\n";
            $body .= 'St John\'s Rd' . "\r\n\r\n";
            $body .= 'Meadowfield' . "\r\n\r\n";
            $body .= 'Durham' . "\r\n\r\n";
            $body .= 'DH7 8XL' . "\r\n\r\n";
            $body .= 'Phone: 01913784979' . "\r\n\r\n";
            // $body .= 'Email: sales@glassassistuk.co.uk'."\r\n\r\n";

            if (!empty($email)) {
                $sendArr = [
                    'subject' => 'Job Card for ' . $vehicle->reg_no,
                    'body'    => $body,
                    'to'      => $email
                ];

                $this->communicationService->sendMailViaSMTP($sendArr, false);
                $this->communicationService->recordSent(
                    'email',
                    'subc',
                    $account->id,
                    0,
                    0,
                    $sendArr['to'],
                    $sendArr['subject'],
                    $sendArr['body']
                );
            }
        }
    }

    public function textJobCardSubscription($vehicleHistoryId)
    {
        if ($vehicleHistoryId) {
            $vehicleHistory = VehicleHistory::query()->findOrFail($vehicleHistoryId);
            $vehicle = $vehicleHistory->vehicle;
            $customer = $vehicleHistory->customer;
            $subContractor = $vehicleHistory->subContractor;

            $makeAndModel = $vehicle->carMake->name . ' ' . $vehicle->carModel->name;

            if (strlen($makeAndModel) > 25) {
                $makeAndModel = substr($makeAndModel, 0, 25);
            }

            if (trim($makeAndModel) == '') {
                $makeAndModel = $vehicleHistory->manual_make_model;
            }

            $datetime = date("l d/m/Y H:i", strtotime($vehicleHistory->datetime));
            $timeAllocatedArray = explode(':', $vehicleHistory->time_allocated);
            $seconds = ($timeAllocatedArray[0] * 60 * 60) + ($timeAllocatedArray[1] * 60);
            $endTime = date('H:i', (strtotime($vehicleHistory->datetime) + $seconds));

            $message = 'Glass Assist Job' . "\n";
            $message .= $vehicleHistory->id . "\n";
            $message .= $datetime . " - " . $endTime . "\n";
            $message .= 'Customer' . "\n";
            $message .= $customer->title . "\n";
            $message .= $customer->first_name . " " . $customer->surname . "\n";
            $message .= $customer->address_1 . "\n";
            $message .= $customer->address_2 . "\n";
            $message .= $customer->city . "\n";
            $message .= $customer->postcode . "\n";
            $message .= $customer->phone . "\n";
            $message .= $customer->mobile . "\n";
            $message .= 'Part Code: ' . $vehicleHistory->part_code . "\n";
            $message .= 'Vehicle Reg: ' . $vehicle->reg_no . "\n";
            $message .= 'VIN Number: ' . $vehicle->vin_number . "\n";
            $message .= 'Make & Model: ' . $makeAndModel . "\n";
            $message .= 'Mileage: ' . $vehicleHistory->mileage . "\n";
            $message .= 'Work Required: ' . $vehicleHistory->work_required . "\n";
            $message .= 'Additional Details: ' . $vehicleHistory->additional_details . "\n";

            /*$this->communicationService->sendSMS(
                0,
                0,
                'instant',
                $message,
                $subContractor->phone
            );

            $this->communicationService->sendSMS(
                0,
                0,
                'instant',
                $message,
                $subContractor->phone_2
            );*/

            $this->communicationService->sendSMS(
                0,
                0,
                'instant',
                $message,
                $vehicleHistory->manual_mobile
            );

            $response = [
                'success' => true,
                'message' => "Message has been sent",
            ];

            return response()->json($response);
        }
    }

    public function serviceReport(int $vehicleHistoryId)
    {
        if ($vehicleHistoryId) {
            $account = auth()->user();
            $vehicleHistory = VehicleHistory::query()->findOrFail($vehicleHistoryId);
            $vehicle = $vehicleHistory->vehicle;
            $customer = $vehicleHistory->customer;
            $subContractor = $vehicleHistory->subContractor;
            $company = $customer->company;

            $checks = [
                1  => 'Check instrument gauges &amp; warning lights',
                2  => 'Carry out battery and alternator test',
                3  => 'Check conditions and operations of all exterior lights and horn',
                4  => 'Check and top up all under bonnet levels (Using accurate fluids)',
                5  => 'Inspect operation and condition of washers and wipers',
                6  => 'Check condition of number plates, exterior mirrors and trim',
                8  => 'Lubricate doors &amp; under bonnet catches',
                9  => 'Check front windscreen for damage',
                10 => 'Check and report on condition and operation of front brakes',
                11 => 'Check and report on condition and operation of rear brakes',
                12 => 'Inspect exhaust system for security and leaks',
                13 => 'Check all steering and suspension joints for condition and security',
                14 => 'Check and report condition of tyres',
                15 => 'Adjust tyre pressure as required',
                16 => 'Check handbrake operation and travel',
                17 => 'Replace engine oil and oil filter (Extra charge for fully synthetic oil)',
                18 => 'Replace Air filter',
                19 => 'Replace sparkplugs (Plugs Prices Vary) petrol only',
                20 => 'Replace Fuel Filter (Diesel engines)',
                21 => 'Replace exterior pollen/cabin filter (Optional at additional cost)',
                22 => 'Check all wheel bearings for noise, roughness and excessive free play',
                24 => 'Check shock absorbers condition and operation',
                25 => 'Check security of fuel lines, brake pipes and handbrake cables',
                26 => 'Visually inspect radiator and coolant pipes/hoses for security and leaks',
                27 => 'Check engine cooling fan for operation',
                28 => 'Check condition and security of fuel cap',
                29 => 'Visually check condition of HT leads / Ignition coils and report',
                30 => 'Check all mountings and gaiters for condition and security',
                31 => 'Check engine, transmission and rear axle for damage and leaks',
                32 => 'Check condition of PAS / Electric Steering, auxiliary and fan belts (Not Timing belt)',
                33 => 'Check engine oil level &amp; Reset Service light',
                34 => 'Stamp customers Service book',
            ];

            $interim_only = array(8, 18, 19, 20, 21, 23, 26, 27, 28, 30, 31, 32);

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(5, 5, 5);
            $pdf->SetHeaderMargin(0);
            $pdf->SetAutoPageBreak(true, 0);

            $pdf->setFontSubsetting(true);

            $pdf->SetFont('Helvetica', '', 10, '', true);

            $pdf->AddPage();

            $uaddress = $account->address_1 . ', ';
            if (strlen($account->address_2) > 0) {
                $uaddress .= $account->address_2 . ', ';
            }
            if (strlen($account->city) > 0) {
                $uaddress .= $account->city . ', ';
            }
            if (strlen($account->county) > 0) {
                $uaddress .= $account->county . ', ';
            }
            if (strlen($account->postcode) > 0) {
                $uaddress .= $account->postcode;
            }

            if (in_array($account->id, array(26, 117))) {
                $pdf->SetFont('Times', '', 10, '', true);
            }

            $html = '<h1 style="font-size: 2em;">' . $account->company_name . '</h1>';
            $pdf->writeHTMLCell(132, 0, '', '', $html, 0, 1, 0, true, 'C', true);

            if (in_array($account->id, array(26, 117))) {
                $pdf->SetFont('Helvetica', '', 10, '', true);
            }

            $html = '<div style="font-size: 0.9em;">' . $uaddress . '<br/>';
            $html .= 'Contact: ' . $account->phone . ' &nbsp; Email: ' . $account->email . '<br/></div>';
            $pdf->writeHTMLCell(132, 0, '', '', $html, 0, 1, 0, true, 'C', true);

            $html = '<table cellpadding="2" style="width: 55%; font-size: 0.8em;">
                            <thead>
                            <tr style="font-size: 1.1em;">
                                <th style="width: 85%; background-color:lightgrey; border: 1px solid darkgray; font-weight: bold; text-align: center; font-size:1.1em;">SERVICE SCHEDULE</th>';
            if ($values['service_type'] == 'interim') {
                $html .= '<th style="width: 15%; background-color:lightgrey; border: 1px solid darkgray; font-weight: bold; text-align: center; font-size:1.1em;">INTERIM SERVICE</th>';
            }
            if ($values['service_type'] == 'full') {
                $html .= '<th style="width: 15%; background-color:lightgrey; border: 1px solid darkgray; font-weight: bold; text-align: center; font-size:1.1em;">FULL SERVICE</th>';
            }
            $html .= '</tr>
                            </thead>
                            <tbody>';

            foreach ($checks as $cno => $check) {
                $html .= '<tr>
                        <td style="width: 85%; border: 1px solid darkgray; font-weight: bold;">' . $check . '</td>';

                if ($values['service_type'] == 'interim') {
                    $html .= '<td style="width: 15%; border: 1px solid darkgray; text-align: center;">';
                    if (!in_array($cno, $interim_only)) {
                        if (isset($values['check_i_' . $cno])) {
                            switch ($values['check_i_' . $cno]) {
                                case 'BLANK':
                                    $html .= '<img src="/assets/images/icons/icon_BLANK.png" style="width:15px;" />';
                                    break;
                                case 'TICK':
                                    $html .= '<img src="/assets/images/icons/icon_TICK.png" style="width:15px;" />';
                                    break;
                                case 'X':
                                    $html .= '<img src="/assets/images/icons/icon_X.png" style="width:15px;" />';
                                    break;
                                case 'NA':
                                    $html .= '<img src="/assets/images/icons/icon_NA.png" style="width:15px;" />';
                                    break;
                                case 'A':
                                    $html .= '<img src="/assets/images/icons/icon_A.png" style="width:15px;" />';
                                    break;
                                case 'ND':
                                    $html .= '<img src="/assets/images/icons/icon_ND.png" style="width:15px;" />';
                                    break;
                            }
                        } else {
                            $html .= '<img src="/assets/images/icons/icon_BLANK.png" style="width:15px;" />';
                        }
                    } else {
                        $html .= '<img src="/assets/images/icons/icon_NA.png" style="width:15px;" />';
                    }
                    $html .= '</td>';
                }

                if ($values['service_type'] == 'full') {
                    $html .= '<td style="width: 15%; border: 1px solid darkgray; text-align: center;">';
                    if (isset($values['check_f_' . $cno])) {
                        switch ($values['check_f_' . $cno]) {
                            case 'BLANK':
                                $html .= '<img src="/assets/images/icons/icon_BLANK.png" style="width:15px;" />';
                                break;
                            case 'TICK':
                                $html .= '<img src="/assets/images/icons/icon_TICK.png" style="width:15px;" />';
                                break;
                            case 'X':
                                $html .= '<img src="/assets/images/icons/icon_X.png" style="width:15px;" />';
                                break;
                            case 'NA':
                                $html .= '<img src="/assets/images/icons/icon_NA.png" style="width:15px;" />';
                                break;
                            case 'A':
                                $html .= '<img src="/assets/images/icons/icon_A.png" style="width:15px;" />';
                                break;
                            case 'ND':
                                $html .= '<img src="/assets/images/icons/icon_ND.png" style="width:15px;" />';
                                break;
                        }
                    } else {
                        $html .= '<img src="/assets/images/icons/icon_BLANK.png" style="width:15px;" />';
                    }
                    $html .= '</td>';
                }

                $html .= '</tr>';
            }

            $html .= '</tbody>
                        </table>';

            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

            //$html = '<div style="font-size:0.8em;"><img src="/assets/images/icons/icon_TICK.png" style="width:15px;" /> = Operation Completed and OK<br/>';
            //$html .= '<img src="/assets/images/icons/icon_X.png" style="width:15px;" /> = Fault Requires Further Work<br/>';
            //$html .= '<img src="/assets/images/icons/icon_NA.png" style="width:15px;" /> = Not Applicable to Vehicle<br/>';
            //$html .= '<img src="/assets/images/icons/icon_A.png" style="width:15px;" /> = Advise<br/></div><br/><br/><br/>';

            $html = '<h4>Tyre Tread Readings</h4>
                        <table style="font-size:0.9em;" cellpadding="3">
                        <thead>
                        <tr>
                            <th style="width:40%;"></th>
                            <th style="width:20%; border:1px solid black; font-weight:bold;">Inner</th>
                            <th style="width:20%; border:1px solid black; font-weight:bold;">Centre</th>
                            <th style="width:20%; border:1px solid black; font-weight:bold;">Outer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th style="width:40%; border:1px solid black; font-weight:bold;">N/S Front</th>
                            <td style="width:20%; border:1px solid black;">' . $values['ns_f_i'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['ns_f_c'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['ns_f_o'] . 'mm</td>
                        </tr>
                        <tr>
                            <th style="width:40%; border:1px solid black; font-weight:bold;">O/S Front</th>
                            <td style="width:20%; border:1px solid black;">' . $values['os_f_i'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['os_f_c'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['os_f_o'] . 'mm</td>
                        </tr>
                        <tr>
                            <th style="width:40%; border:1px solid black; font-weight:bold;">O/S Rear</th>
                            <td style="width:20%; border:1px solid black;">' . $values['os_r_i'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['os_r_c'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['os_r_o'] . 'mm</td>
                        </tr>
                        <tr>
                            <th style="width:40%; border:1px solid black; font-weight:bold;">N/S Rear</th>
                            <td style="width:20%; border:1px solid black;">' . $values['ns_r_i'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['ns_r_c'] . 'mm</td>
                            <td style="width:20%; border:1px solid black;">' . $values['ns_r_o'] . 'mm</td>
                        </tr>
                        </tbody>
                    </table>';

            $html .= '<h4>Service Comments</h4>';
            $html .= '<p style="font-size: 0.9em; font-weight: bold;">' . nl2br($values['comments']) . '</p>';
            $html .= '<h4>Vehicle Condition</h4>';
            $html .= '<p style="font-size: 0.9em; font-weight: bold;">' . nl2br($values['condition']) . '</p>';

            $pdf->writeHTMLCell(85, 0, 120, 45, $html, 0, 1, 0, true, '', true);

            $html = '<table cellpadding="2" style="font-weight: bold;">
                    <tr>
                        <td style="border: 1px solid darkgray; width:40%;">Name: ' . $customer->title . ' ' . $customer->first_name . ' ' . $customer->surname . '</td>
                        <td style="border: 1px solid darkgray; width:20%;">VRM: ' . $vehicle->reg_no . '</td>
                        <td style="border: 1px solid darkgray; width:20%;">Mileage: ' . $vehicleHistory->miles . '</td>
                        <td style="border: 1px solid darkgray; width:20%;">Date: ' . date(
                    'd/m/Y',
                    strtotime($vehicleHistory->datetime)
                ) . '</td>
                    </tr>
                    </table>';
            $pdf->writeHTMLCell(0, 0, '', 280, $html, 0, 1, 0, true, '', false);

            if (strlen($account->logo) > 0) {
                $logoText = '<div><img src="/upload/' . $account->logo . '" style="height:80px;" /></div>';
                $pdf->writeHTMLCell(0, 0, 155, 5, $logoText, 0, 1, 0, true, '', true);
            }

            $filename = time() . '_' . uniqid() . '_service_report_' . $vehicleHistory->id . '.pdf';
            $pdf->Output(PHYS_UPLOAD_PATH . $filename, 'F');
            VehicleHistory::save_document_to_booking($filename, $vehicleHistory->id);

            $pdf->Output($filename, 'I');
        }
    }

    public function jobCardsForDate()
    {
        if (isset($_GET['date'])) {
            $account = auth()->user();

            $histories = VehicleHistory::get_all_for_date($_GET['date']);

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(0);

            $pdf->setFontSubsetting(true);

            $pdf->SetFont('Helvetica', '', 10, '', true);

            foreach ($histories as $vehicleHistory) {
                $pdf->AddPage();

                $html = self::get_job_card_html($vehicleHistory['id'], 1);

                $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

                $pdf->AddPage();

                $html = self::get_job_card_html($vehicleHistory['id'], 2);

                $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
            }

            $pdf->Output('jobcards_' . $_GET['date'] . '.pdf', 'I');
        }
    }

    /**
     * @param int $vehicleHistoryId
     * @param int $page
     * @return string
     */
    public function getJobCardHtml(int $vehicleHistoryId, int $page = 1): string
    {
        $account = auth()->user();
        $currentView = Route::currentRouteName();
        $vehicleHistory = VehicleHistory::query()->findOrFail($vehicleHistoryId);
        $vehicle = $vehicleHistory->vehicle;
        $customer = $vehicleHistory->customer;
        $subContractor = $vehicleHistory->subContractor;
        $company = $customer->company;
        $datetime = date("l d/m/Y H:i", strtotime($vehicleHistory->datetime));
        $timeAllocatedArray = explode(':', $vehicleHistory->time_allocated);
        $seconds = ($timeAllocatedArray[0] * 60 * 60) + ($timeAllocatedArray[1] * 60);
        $endTime = date('H:i', (strtotime($vehicleHistory->datetime) + $seconds));
        $logoText = '<h2>' . $account->company_name . '</h2>';
        $makeAndModel = $vehicle->carMake->name . ' ' . $vehicle->carModel->name;

        if (strlen($account->logo) > 0) {
            $logoText = '<img src="/upload/' . $account->logo . '" style="height:80px;" />';
        }

        if (substr($customer->mobile, 0, 2) == '44') {
            $customer->mobile = '0' . substr($customer->mobile, 2);
        }

        if (strlen($makeAndModel) > 25) {
            $makeAndModel = substr($makeAndModel, 0, 25);
        }

        if (trim($makeAndModel) == '') {
            $makeAndModel = $vehicleHistory->manual_make_model;
        }

        $html = "<table cellpadding=\"5\" cellspacing=\"0\" style=\"width:100%;\">
                        <tr>
                            <td style=\"padding:5px; width:50%;\">
                                " . $logoText . "
                                <br/>
                             &nbsp;&nbsp;&nbsp;&nbsp; ISO &nbsp;  - &nbsp;  9001 &nbsp;  - &nbsp; 14001 &nbsp; - &nbsp; 45001
                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            </td>
                            <td style=\"border:1px solid black; padding:3px; width:50%;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-size:14px; font-weight:bold; width:40%;\">Job Card</td>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:40%;\">Job Number:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $vehicleHistory->id . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Date/Time:</td>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">" . $datetime . " - " . $endTime . "</td>
                                    </tr>
                                   
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style=\"padding:5px; border:1px solid black;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Business:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $customer->business . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\" colspan='2'>Title</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . ucfirst(
                $customer->title
            ) . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Name:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $customer->first_name . " " . $customer->surname . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Address:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->address_1 . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->address_2 . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->city . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Post Code:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->postcode . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Tel No:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->phone . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Mobile No:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->mobile . "</td>
                                    </tr>
                                </table>
                            </td>
                            <td style=\"padding:5px; border:1px solid black;\">";

        if ($currentView != 'pdf.job-card-subscription' && $currentView != 'pdf.email-job-card-subscription' && $company) {
            $html .= "<table>
                            <tr>
                                <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\" colspan='2'>Company</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Name:</td>
                                <td style=\"padding:5px; line-height:17px; width:70%;\">" . $company->name . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Address:</td>
                                <td style=\"padding:5px; line-height:17px;\">" . $company->address_1 . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; line-height:17px;\"></td>
                                <td style=\"padding:5px; line-height:17px;\">" . $company->address_2 . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; line-height:17px;\"></td>
                                <td style=\"padding:5px; line-height:17px;\">" . $company->city . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Post Code:</td>
                                <td style=\"padding:5px; line-height:17px;\">" . $company->postcode . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Tel No:</td>
                                <td style=\"padding:5px; line-height:17px;\">" . $company->phone . "</td>
                            </tr>
                        </table>";
        }

        $html .= "
                            </td>
                        </tr>
                    </table>
                    <table>
                        <br/><br/>
                        <tr>
                            <td style=\"padding:5px; border:1px solid black;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Vehicle Reg:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $vehicle->reg_no . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Make & Model:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $makeAndModel . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">VIN Number:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $vehicle->vin_number . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Milage:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $vehicleHistory->mileage . "</td>
                                    </tr>
                                </table>
                            </td>
                            <td style=\"padding:5px; border:1px solid black;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Order Number:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $vehicleHistory->order_number . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Part Code:</td>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; font-size: 12px;\">" . $vehicleHistory->part_code . "</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br/><br/>
                    <table cellpadding=\"5\" cellspacing=\"0\" style=\"width:100%;\">";

        if ($currentView != 'pdf.job-card-subscription' && $currentView != 'pdf.email-job-card-subscription') {
            $html .= "
                            <tr>
                                <td><h3>Job Cost</h3></td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; width:100%; border:1px solid black; height:40px;\">" . $vehicleHistory->job_cost . "</td>
                            </tr>";
        }

        $html .= "
                            <tr>
                                <td><h3>Work Required</h3></td>
                            </tr>
                            <tr>
                               <td style=\"padding:5px; width:100%; border:1px solid black; height:40px;\">" . $vehicleHistory->work_required . "</td>
                            </tr>
                        
                            <tr>
                                <td><h3>Additional Details</h3></td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; width:100%; border:1px solid black; height:40px;\">" . $vehicleHistory->additional_details . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; width:30%; height:40px;\"><h3>Sub-Contractor</h3></td>
                                <td style=\"padding:5px; width:70%; height:40px;\">" . $subContractor->name . "</td>
                            </tr>
                        </table>
                    ";
        $html .= '<table style=\"width:100%;\">
                        <tr>
                            <td style=\"padding:5px; width:30%; height:40px;\"><h3 style="text-align: center; font-weight: bold; color: red;">BODY SHOP TECHNICIAN and AOM 230 ADAS TECHNICIAN</h3></td>
                        </tr>
                        <tr>
                            <td style=\"padding:5px; width:30%; height:40px;\"><h4 style="text-align: center; font-weight: bold; color: red;">Please Contact us if you require new accreditation or refresher</h4></td>
                        </tr>
                        <tr>
                            <td style=\"padding:5px; width:30%; height:40px;\"><h4 style="text-align: center; font-weight: bold; color: red;">Email <a href="mailto:admin@gauk.org">admin@gauk.org</a> for more details</h4></td>
                        </tr>
                    </table>
                    <br/><br/>
                    <table>
                        <tr>
                            <td style="width: 45%;"><img src="/assets/images/footer.png" style="width:130px; height: 60px; float: left"></td>
                            <td style="width: 40%;"><img src="/assets/images/ISO.jpeg" style="width:100px; height: 70px;"></td>
                            <td><img src="/assets/images/footer2.png" style="width:60px; height: 70px; padding-right: 20px"></td>
                        </tr>
                    </table>';

        if ($page == 1) {
            return $html;
        }

        $jobCardHtml = '';
        for ($i = 1; $i < 15; $i++) {
            $jobCardHtml .= '<tr>
                            <td style="border:1px solid black; height:10px;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                        </tr>';
        }

        $partsUsedHtml = '';
        for ($i = 1; $i < 13; $i++) {
            $partsUsedHtml .= '<tr>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                        </tr>';
        }

        $html = "<table cellpadding=\"3\" cellspacing=\"0\" style=\"width:100%;\">
                    <tr style=\"font-weight:bold;\">
                        <td style=\"border:1px solid black; width:35%;\">Parts/Quotation:<br/>(Include Part No if applicable)</td>
                        <td style=\"border:1px solid black; width:15%;\">Cost Price (ex. VAT)</td>
                        <td style=\"border:1px solid black; width:10%;\">Sales Price (ex. VAT)</td>
                        <td style=\"border:1px solid black; width:10%;\">Labour Time</td>
                        <td style=\"border:1px solid black; width:10%;\">Labour Cost</td>
                        <td style=\"border:1px solid black; width:12%;\">Total Cost (inc VAT)</td>
                        <td style=\"border:1px solid black; width:8%;\">Auth</td>
                    </tr>

                    " . $jobCardHtml . "
                </table>

                <h3>Work Carried Out By Technician Named: ______________________</h3>
                <div style=\"width:100%; border:1px solid black;\"><div><div><div><div><div><div><div><div><div><div></div></div></div></div></div></div></div></div></div></div></div>
                <h3 style='padding-top:3px;'>Parts Used:</h3>

                <table cellpadding=\"3\" cellspacing=\"0\" style=\"width:100%;\">
                    <tr style=\"font-weight:bold;\">
                        <td style=\"border:1px solid black; width:10%;\">Stock</td>
                        <td style=\"border:1px solid black; width:12%;\">Non-Stock</td>
                        <td style=\"border:1px solid black; width:10%;\">Quantity</td>
                        <td style=\"border:1px solid black; width:38%;\">Description</td>
                        <td style=\"border:1px solid black; width:15%;\">Manufacturer</td>
                        <td style=\"border:1px solid black; width:15%;\">Glass Supplier Ref<br/>(if non-stock)</td>
                    </tr>

                    " . $partsUsedHtml . "
                </table>";

        if ($page == 2) {
            return $html;
        }
    }

    /**
     * @param int $vehicleHistoryId
     * @param int $page
     * @return string
     */
    public function getSubJobCardHtml(int $vehicleHistoryId, int $page = 1): string
    {
        if ($vehicleHistoryId) {
            $account = auth()->user();
            $currentView = Route::currentRouteName();
            $vehicleHistory = VehicleHistory::query()->findOrFail($vehicleHistoryId);
            $vehicle = $vehicleHistory->vehicle;
            $customer = $vehicleHistory->customer;
            $subContractor = $vehicleHistory->subContractor;
            $company = $customer->company;
            $datetime = date("l d/m/Y H:i", strtotime($vehicleHistory->datetime));
            $timeAllocatedArray = explode(':', $vehicleHistory->time_allocated);
            $seconds = ($timeAllocatedArray[0] * 60 * 60) + ($timeAllocatedArray[1] * 60);
            $endTime = date('H:i', (strtotime($vehicleHistory->datetime) + $seconds));
            $logoText = '<h2>' . $account->company_name . '</h2>';
            $makeAndModel = ($vehicle->carMake ? $vehicle->carMake->name : "") . ' ' . ($vehicle->carModel ? $vehicle->carModel->name : "");

            if (strlen($account->logo) > 0) {
                $logoText = '<img src="/upload/' . $account->logo . '" style="height:80px;" />';
            }

            if (substr($customer->mobile, 0, 2) == '44') {
                $customer->mobile = '0' . substr($customer->mobile, 2);
            }

            if (strlen($makeAndModel) > 25) {
                $makeAndModel = substr($makeAndModel, 0, 25);
            }

            if (trim($makeAndModel) == '') {
                $makeAndModel = $vehicleHistory->manual_make_model;
            }

            $html = "
                    <table cellpadding=\"5\" cellspacing=\"0\" style=\"width:100%;\">
                        <tr>
                            <td style=\"padding:5px; width:50%;\">
                                " . $logoText . "
                                <br/>
                             &nbsp;&nbsp;&nbsp;&nbsp; ISO &nbsp;  - &nbsp;  9001 &nbsp;  - &nbsp; 14001 &nbsp; - &nbsp; 45001
                            
                                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            </td>
                            <td style=\"border:1px solid black; padding:3px; width:50%;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-size:14px; font-weight:bold; width:100%;\">Job Card - Sub C</td>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:40%;\">Job Number:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $vehicleHistory->id . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Date/Time:</td>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">" . $datetime . " - " . $endTime . "</td>
                                    </tr>
                                   
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style=\"padding:5px; border:1px solid black;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Business:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $customer->business . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\" colspan='2'>Title</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . ucfirst(
                    $customer->title
                ) . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Name:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $customer->first_name . " " . $customer->surname . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Address:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->address_1 . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->address_2 . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->city . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Post Code:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->postcode . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Tel No:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->phone . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Mobile No:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $customer->mobile . "</td>
                                    </tr>
                                </table>
                            </td>
                            <td style=\"padding:5px; border:1px solid black;\">";

            if ($currentView != 'pdf.job-card-subscription' && $currentView != 'pdf.email-job-card-subscription') {
                $html .= "
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\" colspan='2'>Company</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Name:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $company->name . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Address:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $company->address_1 . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $company->address_2 . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $company->city . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Post Code:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $company->postcode . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Tel No:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $company->phone . "</td>
                                    </tr>
                                </table>";
            }

            $html .= "
                            </td>
                        </tr>
                    </table>
                    <table>
                        <br/><br/>
                        <tr>
                            <td style=\"padding:5px; border:1px solid black;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Vehicle Reg:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $vehicle->reg_no . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Make & Model:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $makeAndModel . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">VIN Number:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $vehicle->vin_number . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Milage:</td>
                                        <td style=\"padding:5px; line-height:17px;\">" . $vehicleHistory->mileage . "</td>
                                    </tr>
                                </table>
                            </td>
                            <td style=\"padding:5px; border:1px solid black;\">
                                <table>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; width:30%;\">Order Number:</td>
                                        <td style=\"padding:5px; line-height:17px; width:70%;\">" . $vehicleHistory->order_number . "</td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                        <td style=\"padding:5px; line-height:17px;\"></td>
                                    </tr>
                                    <tr>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold;\">Part Code:</td>
                                        <td style=\"padding:5px; line-height:17px; font-weight:bold; font-size: 12px;\">" . $vehicleHistory->part_code . "</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br/><br/>
                    <table cellpadding=\"5\" cellspacing=\"0\" style=\"width:100%;\">";

            if ($currentView != 'pdf.job-card-subscription' && $currentView != 'pdf.email-job-card-subscription') {
                $html .= "
                            <tr>
                                <td><h3>Job Cost</h3></td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; width:100%; border:1px solid black; height:40px;\">" . $vehicleHistory->job_cost . "</td>
                            </tr>";
            }

            $html .= "
                            <tr>
                                <td><h3>Work Required</h3></td>
                            </tr>
                            <tr>
                               <td style=\"padding:5px; width:100%; border:1px solid black; height:40px;\">" . $vehicleHistory->work_required . "</td>
                            </tr>
                        
                            <tr>
                                <td><h3>Additional Details</h3></td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; width:100%; border:1px solid black; height:40px;\">" . $vehicleHistory->additional_details . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding:5px; width:30%; height:40px;\"><h3>Sub-Contractor</h3></td>
                                <td style=\"padding:5px; width:70%; height:40px;\">" . $subContractor->name . "</td>
                            </tr>
                        </table>
                    ";
            $html .= '<table style=\"width:100%;\">
                        <tr>
                            <td style=\"padding:5px; width:30%; height:40px;\"><h3 style="text-align: center; font-weight: bold; color: red;">BODY SHOP TECHNICIAN and AOM 230 ADAS TECHNICIAN</h3></td>
                        </tr>
                        <tr>
                            <td style=\"padding:5px; width:30%; height:40px;\"><h4 style="text-align: center; font-weight: bold; color: red;">Please Contact us if you require new accreditation or refresher</h4></td>
                        </tr>
                        <tr>
                            <td style=\"padding:5px; width:30%; height:40px;\"><h4 style="text-align: center; font-weight: bold; color: red;">Email <a href="mailto:admin@gauk.org">admin@gauk.org</a> for more details</h4></td>
                        </tr>
                    </table>
                    <br/><br/>
                    <table>
                        <tr>
                            <td style="width: 45%;"><img src="/assets/images/footer.png" style="width:130px; height: 60px; float: left"></td>
                            <td style="width: 40%;"><img src="/assets/images/ISO.jpeg" style="width:100px; height: 70px;"></td>
                            <td><img src="/assets/images/footer2.png" style="width:60px; height: 70px; padding-right: 20px"></td>
                        </tr>
                    </table>';

            if ($page == 1) {
                return $html;
            }

            $jobCardHtml = '';
            for ($i = 1; $i < 15; $i++) {
                $jobCardHtml .= '<tr>
                            <td style="border:1px solid black; height:10px;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                        </tr>';
            }

            $partsUsedHtml = '';
            for ($i = 1; $i < 13; $i++) {
                $partsUsedHtml .= '<tr>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                            <td style="border:1px solid black;"></td>
                        </tr>';
            }

            $html = "
                    <table cellpadding=\"3\" cellspacing=\"0\" style=\"width:100%;\">
                        <tr style=\"font-weight:bold;\">
                            <td style=\"border:1px solid black; width:35%;\">Parts/Quotation:<br/>(Include Part No if applicable)</td>
                            <td style=\"border:1px solid black; width:15%;\">Cost Price (ex. VAT)</td>
                            <td style=\"border:1px solid black; width:10%;\">Sales Price (ex. VAT)</td>
                            <td style=\"border:1px solid black; width:10%;\">Labour Time</td>
                            <td style=\"border:1px solid black; width:10%;\">Labour Cost</td>
                            <td style=\"border:1px solid black; width:12%;\">Total Cost (inc VAT)</td>
                            <td style=\"border:1px solid black; width:8%;\">Auth</td>
                        </tr>

                        " . $jobCardHtml . "
                    </table>

                    <h3>Work Carried Out By Technician Named: ______________________</h3>
                    <div style=\"width:100%; border:1px solid black;\"><div><div><div><div><div><div><div><div><div><div></div></div></div></div></div></div></div></div></div></div></div>
                    <h3 style='padding-top:3px;'>Parts Used:</h3>

                    <table cellpadding=\"3\" cellspacing=\"0\" style=\"width:100%;\">
                        <tr style=\"font-weight:bold;\">
                            <td style=\"border:1px solid black; width:10%;\">Stock</td>
                            <td style=\"border:1px solid black; width:12%;\">Non-Stock</td>
                            <td style=\"border:1px solid black; width:10%;\">Quantity</td>
                            <td style=\"border:1px solid black; width:38%;\">Description</td>
                            <td style=\"border:1px solid black; width:15%;\">Manufacturer</td>
                            <td style=\"border:1px solid black; width:15%;\">Glass Supplier Ref<br/>(if non-stock)</td>
                        </tr>

                        " . $partsUsedHtml . "
                    </table>";

            if ($page == 2) {
                return $html;
            }
        }
    }

    public function bookingInvoice($vehicleHistoryId, $invoiceDate)
    {
        if ($vehicleHistoryId) {
            $account = auth()->user();

            $vehicleHistory = VehicleHistory::query()->findOrFail($vehicleHistoryId);
            $vehicle = $vehicleHistory->vehicle;
            $customer = $vehicleHistory->customer;

            $ref_no = $vehicleHistory->id;
            if (strlen($vehicleHistoryId->invoice_number) > 0) {
                $ref_no = $vehicleHistoryId->invoice_number;
            }

            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            if ($account->show_invoice_margin == 0) {
                $pdf->setPrintHeader(true);
                $pdf->setPrintFooter(true);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(5);
                $pdf->SetFooterMargin(5);
                $pdf->SetAutoPageBreak(true, PDF_MARGIN_FOOTER + 25);
            } else {
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(true);
                $pdf->SetMargins(PDF_MARGIN_LEFT, $account->invoice_margin_top + 5, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin($account->invoice_margin_top + 5);
                $pdf->SetFooterMargin($account->invoice_margin_bottom + 5);
                $pdf->SetAutoPageBreak(true, $account->invoice_margin_bottom + 5);
            }

            $pdf->setFontSubsetting(true);

            $pdf->SetFont('Helvetica', '', 10, '', true);

            $pdf->AddPage();

            //$invoiceDate = date("d/m/Y");
            if (isset($_GET['invoice_date'])) {
                if (strtotime($_GET['invoice_date']) > 0) {
                    $invoiceDate = date("d/m/Y", strtotime($_GET['invoice_date']));
                } else {
                    $invoiceDate = date("d/m/Y", strtotime($vehicleHistoryId->date_added));
                }
            } else {
                $invoiceDate = date("d/m/Y", strtotime($vehicleHistoryId->date_added));
            }


            $amountWithVat = 10;//number_format($order->amt,2);
            $amountWithoutVat = 10;//number_format(($order->amt / 1.2),2);
            $vat = 10;//number_format(($amountWithoutVat * 0.2),2);
            $address = '';
            if (strlen($customer->company_name) > 0) {
                $address .= $customer->company_name . '<br/>';
            }
            if (strlen($customer->address_1) > 0) {
                $address .= $customer->address_1 . '<br/>';
            }
            if (strlen($customer->address_2) > 0) {
                $address .= $customer->address_2 . '<br/>';
            }
            if (strlen($customer->city) > 0) {
                $address .= $customer->city . '<br/>';
            }
            if (strlen($customer->county) > 0) {
                $address .= $customer->county . '<br/>';
            }
            if (strlen($customer->postcode) > 0) {
                $address .= $customer->postcode;
            }

            $html = '        
                    <h2 style="text-align:center; font-size:16pt;">' . ($vehicleHistoryId->invoice_type == 'quote' ? 'Quote' : 'Invoice') . '</h2>

                    <table cellspacing="0" cellpadding="5" style="font-weight:bold; font-size:1.1em;">
                        <tr>
                            <td style="border:1px solid #ddd;">' . (strlen(
                    $customer->company_name
                ) > 0 ? $customer->company_name : $customer->title . ' ' . $customer->first_name . ' ' . $customer->surname) . '</td>
                            <td style="border:1px solid #ddd;">Ref No: ' . $ref_no . '</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #ddd;" colspan="2">' . $address . '</td>
                        </tr>
                    </table>

                    <br/><br/><br/>

                    <table cellspacing="0" cellpadding="5">
                        <tr>
                            <th style="border:1px solid #ddd; width:15%; font-weight:bold;">Make</th>
                            <th style="border:1px solid #ddd; width:15%; font-weight:bold;">Model</th>
                            <th style="border:1px solid #ddd; width:15%; font-weight:bold;">Reg No</th>
                            <th style="border:1px solid #ddd; width:15%; font-weight:bold;">Mileage</th>
                            <th style="border:1px solid #ddd; width:25%; font-weight:bold;">VIN Number</th>
                            <th style="border:1px solid #ddd; width:15%; font-weight:bold;">' . ($vehicleHistoryId->invoice_type == 'quote' ? 'Quote' : 'Invoice') . ' Date</th>
                        </tr>
                        <tr>
                            <td style="border:1px solid #ddd;">' . $vehicle->make . '</td>
                            <td style="border:1px solid #ddd;">' . $vehicle->model . '</td>
                            <td style="border:1px solid #ddd;">' . $vehicle->reg_no . '</td>
                            <td style="border:1px solid #ddd;">' . $vehicleHistoryId->miles . '</td>
                            <td style="border:1px solid #ddd;">' . $vehicle->vin_number . '</td>
                            <td style="border:1px solid #ddd;">' . $invoiceDate . '</td>
                        </tr>
                    </table>

                    <br/><br/><br/>

                    <table cellspacing="0" cellpadding="5">
                        <tr>
                            <th style="border:1px solid #ddd; width:65%; text-align:left;">Description</th>
                            <th style="border:1px solid #ddd; width:20%; text-align:right;">Unit Price</th>
                            <th style="border:1px solid #ddd; width:15%; text-align:right;">Amount</th>
                        </tr>';

            $total = 0;
            $vat = 0;
            $subtotal = 0;
            $misc = 0;
            $gross = 0;
            $discount = 0;

            $misc_html = '';
            $job_type = '';

            foreach ($jobcarditems as $item) {
                $thistotal = 0;
                $thisvat = 0;
                $thismisc = 0;
                $thistotal = $item['sell_price'];
                $thisvat = $item['sell_price'] * 0.20;

                $total = $total + $thistotal;
                $vat = $vat + $thisvat;

                $html .= '
                                <tr>
                                    <td style="display: none;">' . $type . '</td>
                                    <td style="border:1px solid #ddd; text-align:left;">' . $item['description'] . '</td>
                                    <td style="border:1px solid #ddd; text-align:right;">&pound;' . number_format(
                        $item['sell_price'],
                        2
                    ) . '</td>
                                    <td style="border:1px solid #ddd; text-align:right;">&pound;' . number_format(
                        $thistotal,
                        2
                    ) . '</td>
                                </tr>';
            }

            if (strlen($misc_html) > 0) {
                $html .= '
                                <tr>
                                    <td colspan="5" style="border:1px solid #ddd; font-weight:bold;"><br/><br/>Non-VAT Items</td>
                                </tr>' . $misc_html;

                $html .= '
                        <tr>
                            <th colspan="4" style="border:1px solid #ddd; text-align:right; font-weight:bold;">Sub Total</th>
                            <td style="border:1px solid #ddd; text-align:right; font-weight:bold;">&pound;' . number_format(
                        $misc,
                        2
                    ) . '</td>
                        </tr>';
            }

            if ($account->vat_registered == 0) {
                $vat = 0;
            }

            $subtotal = $total + $vat;
            $gross = $total + $vat - $discount;

            $html .= '
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td rowspan="5" style="border:1px solid #ddd; margin:20px; padding:20px; font-weight:bold;">NOTES:<br/>' . str_replace(
                    "\n",
                    "<br/>",
                    $vehicleHistoryId->invoice_notes
                ) . '</td>
                            <th style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">Sub Total</th>
                            <td style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">&pound;' . number_format(
                    $total,
                    2
                ) . '</td>
                        </tr>';

            if ($account->vat_registered == 1) {
                $html .= '<tr>
                                <th style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">VAT @ 20%</th>
                                <td style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">&pound;' . number_format(
                        $vat,
                        2
                    ) . '</td>
                            </tr>';
            }

            if ($discount > 0) {
                $html .= '<tr>
                                <th style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">Discount</th>
                                <td style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">-&pound;' . number_format(
                        $discount,
                        2
                    ) . '</td>
                            </tr>';
            }

            $html .= '<tr>
                            <th style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">Total</th>
                            <td style="border:1px solid #ddd; text-align:right; font-weight:bold; background-color:lightgrey;">&pound;' . number_format(
                    $gross,
                    2
                ) . '</td>
                        </tr>
                    </table><br/><br/><br/><br/><br/>
                    <p>Why you should choose Glass Assist UK Limited</p><br/>
                            <ul>
                                <li>Competitively Priced automotive glass replacement specialists.</li>
                                <li>Lifetime Warranty on materials and workmanship.</li>
                                <li>Quality materials used in accordance with the vehicle manufacturers specifications.</li>
                                <li>We Come to You at home, at work or any convenient location, and at a time that suits your plans.</li>
                                <li>Fully Qualified & Certified fitters trained to the highest industry standards.</li>
                                <li>Reputation. 20 Years as a leading name in the Automotive Glazing Industry</li>
                            </ul>
                                <p>Book your vehicle now. Call us FREE and quote your registration or quotation reference.<p><br/>
                                <p> THIS QUOTATION IS VALID FOR 60 DAYS</p>';

            if ($account->show_invoice_margin == 0) {
                $pdf->writeHTMLCell(0, 0, '', 50, $html, 0, 1, 0, true, '', true);
            } else {
                $pdf->writeHTMLCell(0, 0, '', $account->invoice_margin_top, $html, 0, 1, 0, true, '', true);
            }

            $filename = time() . '_' . uniqid(
                ) . '_' . ($vehicleHistoryId->invoice_type == 'quote' ? 'quote' : 'invoice') . '_' . $vehicleHistoryId->id . '.pdf';
            $pdf->Output(PHYS_UPLOAD_PATH . $filename, 'F');
            VehicleHistory::save_document_to_booking($filename, $vehicleHistoryId->id);

            $pdf->Output($filename, 'I');
        }
    }
}
