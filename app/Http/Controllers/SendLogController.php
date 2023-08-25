<?php

namespace App\Http\Controllers;


use App\Services\SendLogService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendLogController extends Controller
{
    /**
     * @var SendLogService
     */
    private $sendLogService;

    /**
     * @param SendLogService $sendLogService
     */
    public function __construct(SendLogService $sendLogService)
    {
        $this->sendLogService = $sendLogService;
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
            $totalRecords = $this->sendLogService->getSentLogsCount();
            $totalRecordsWithFilter = $this->sendLogService->getSentLogsCount($this->searchValue);

            $sends = $this->sendLogService->getSentLogs(
                $this->columnName,
                $this->columnSortOrder,
                $this->searchValue,
                $this->start,
                $this->rowPerPage
            );

            $results = [];
            foreach ($sends as $send) {
                $customer = $send->customer;
                $results[] = [
                    'type' => $send->type,
                    'dateSent' => $send->date_sent,
                    'customer' => $customer ? $customer->first_name : '',
                    'recipient' => $send->recipient,
                    'message' => $send->message
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

        return view('send-log/index');
    }
}
