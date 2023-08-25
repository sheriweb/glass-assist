<?php

namespace App\Helpers;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasicHelpers
{
    /**
     * @param $max
     * @return string
     */
    public static function generateSalt($max = 15): string
    {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $salt = "";

        while ($i < $max) {
            $salt .= $characterList[mt_rand(0, strlen($characterList) - 1)];
            $i++;
        }

        return $salt;
    }

    /**
     * @param $input
     * @param $salt
     * @return string
     */
    public static function encryptPassword($input, $salt): string
    {
        return str_rot13(base64_encode(hash('sha512', $input . $salt)));
    }

    /**
     * @param $obj
     * @return float
     */
    public static function getDays($obj): float
    {
        if (isset($obj->ampm) && ($obj->ampm === 'am' || $obj->ampm === 'pm')) {
            return 0.5;
        }

        try {
            $datetime1 = new DateTime($obj->date_from);
            $datetime2 = new DateTime($obj->date_to);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');

            return (float)$days + 1;
        } catch (Exception $e) {
            return 0.0;
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public static function upload(Request $request, string $filename = 'image', $path = null): string
    {
        $file = $request->file($filename);
        $destinationPath = $path ?? 'files/';
        $file_name = time() . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $file_name);

        return $file_name;
    }

    public static function messageReplace($message, $vehicleRegNo, $date = '', $time = '')
    {
        $account = Auth::user();

        $message = str_replace('[REGNO]', $vehicleRegNo, $message);
        $message = str_replace('[PHONE]', $account->phone, $message);
        $message = str_replace('[COMPANYNAME]', $account->company_name, $message);
        $message = str_replace('[RELATED]', $account->tag_vehicle, $message);
        $message = str_replace('[DUEDATE1]', $account->tag_due_date_1, $message);
        $message = str_replace('[DUEDATE2]', $account->tag_due_date_2, $message);
        $message = str_replace('[DUEDATE3]', $account->tag_due_date_3, $message);
        $message = str_replace('[DATE]', $date, $message);
        $message = str_replace('[TIME]', $time, $message);

        return $message;
    }
}
