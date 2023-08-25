<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'email'         => ['required'],
            'password'      => ['required'],
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiLogin(Request $request): JsonResponse
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $request->session()->regenerate();

            return sendApiError(json_encode($validator->errors()->messages()), [], 401);
        }

        try {
            $user = $this->userService->login($request->all());

            if ($user->access_level === 5) {
                $token = $user->createToken($request->device_name ?? 'Personal Access Token')->plainTextToken;

                return sendApiResponse([
                    'name' => $user->first_name . ' ' . $user->surname,
                    'token' => $token
                ], 'Success');
            }

            return sendApiError('Unauthenticated', [ 'error' => 'You don"t have access.' ], 403);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return sendApiError($e->getMessage(), [], 500);
        }
    }
}
