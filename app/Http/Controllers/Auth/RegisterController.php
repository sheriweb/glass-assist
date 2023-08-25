<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\StaticMessages;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\BasicHelpers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * Create a new controller instance.
     *
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
        return view('auth/register');
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
            'company_name'  => ['required', 'string', 'max:255'],
            'first_name'    => ['required', 'string', 'max:255'],
            'surname'       => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     * @throws Exception
     */
    protected function create(array $data): User
    {
        $salt = BasicHelpers::generateSalt();

        return $this->userService->create([
            'company_name'  => $data['company_name'],
            'address_1'     => $data['address_one'],
            'address_2'     => $data['address_two'],
            'city'          => $data['city'],
            'country'       => $data['city'],
            'postcode'      => $data['post_code'],
            'first_name'    => $data['first_name'],
            'phone'         => $data['phone'],
            'mobile'        => $data['mobile'],
            'title'         => $data['title'],
            'surname'       => $data['surname'],
            'username'      => $data['username'],
            'email'         => $data['email'],
            'account_level' => $data['account_level'],
            'password_salt' => $salt,
            'password'      => BasicHelpers::encryptPassword($data['password'], $salt)
        ]);
    }

    /**
     * User Register method
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with([
                    'message' => StaticMessages::$INVALID_REQUEST,
                    'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                ])
                ->withErrors($validator->errors())
                ->withInput();
        }

        try {
            $user = $this->create($request->all());

            auth()->login($user);

            return redirect()->route('dashboard')
                ->with([
                    'message' => StaticMessages::$SIGN_UP_SUCCESS,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with([
                    'message' => $e->getMessage(),
                    'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                ]);
        }
    }
}
