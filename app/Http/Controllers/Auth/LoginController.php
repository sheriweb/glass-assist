<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\StaticMessages;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @var string
     */
    private $username;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('auth/login');
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
                'email'    => ['required', 'max:255'],
                'password' => ['required', 'max:255'],
            ]
        );
    }

    /**
     * User login API method
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with(
                    [
                        'message'    => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ]
                )
                ->withErrors($validator->errors())
                ->withInput();
        }

        try {
            $user = $this->userService->login($request->all());
            Auth::loginUsingId($user->id, $request->get('remember') === 'on');

            if ($user->access_level === 5) {
                return redirect()->route('technician-bookings')
                    ->with(
                        [
                            'message'    => StaticMessages::$UPDATED,
                            'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                        ]
                    );
            }

            return redirect()->route('booking.calendar', 'local')
                ->with(
                    [
                        'message'    => StaticMessages::$LOGIN_SUCCESS,
                        'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                    ]
                );
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with(
                    [
                        'message'    => $e->getMessage(),
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ]
                )
                ->withErrors(
                    [
                        'email' => $e->getMessage()
                    ]
                )
                ->withInput();
        }
    }
}
