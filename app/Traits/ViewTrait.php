<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ViewTrait
{
    /**
     * @param Request $request
     * @return bool
     */
    public function canViewAddVehicle(Request $request): bool
    {
        $users = [24, 26, 50, 117, 121, 122];

        if (in_array($request->user()->account_id, $users)) {
            return true;
        }

        return false;
    }
}
