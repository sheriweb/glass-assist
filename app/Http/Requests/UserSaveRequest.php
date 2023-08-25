<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $password = 'required|string|max:255';
        if ($request->user_id) {
            $password = '';
        }
        return [
            'first_name' => 'required|string|max:255',
            'surname' =>  'required|string|max:255',
            'email' =>  'required',
            'password' =>  $password,
            'username' =>  'required|string|max:255',
            'access_level' =>  'required|string|max:255'
        ];
    }

    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getRedirectUrl())
            ->withInput($request->input())
            ->withErrors($errors, $this->errorBag());
    }
}
