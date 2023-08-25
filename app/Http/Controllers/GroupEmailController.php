<?php

namespace App\Http\Controllers;


use App\Helpers\StaticMessages;
use App\Services\GroupEmailService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GroupEmailController extends Controller
{
    /**
     * @var GroupEmailService
     */
    private $groupEmailService;

    /**
     * @param GroupEmailService $groupEmailService
     */
    public function __construct(GroupEmailService $groupEmailService)
    {
        $this->groupEmailService = $groupEmailService;
    }

    /**
     * Show the group-email/index.blade.php.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $groupEmails = $this->groupEmailService->getGroupEmailsPaginator();

        return view('group-email/index', [
            'groupEmails' => $groupEmails
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function newGroupEmail(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->groupEmailService->createGroupEmail($request->all());

            return redirect()->route('group-email')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        return view('group-email.new');
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View
     */
    public function viewGroupEmail(Request $request, $id)
    {
        $groupEmail  = $this->groupEmailService->getGroupEmail($id);

        return view('group-email.view', [
            'groupEmail'  => $groupEmail,
        ]);
    }
}
