<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use ClickSend\Api\AccountApi;
use ClickSend\ApiException;
use ClickSend\Configuration;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function __invoke()
    {
        $user = auth()->user();
        $vehicleCount = Vehicle::count();
        $customerCount = Customer::count();
        $dVLACreditBalance = $this->countDVLACredits();
        $smsBalance = $this->getCredits();

        return view(
            'dashboard',
            compact(
                'user',
                'vehicleCount',
                'customerCount',
                'dVLACreditBalance',
                'smsBalance'
            )
        );
    }

    public function countDVLACredits()
    {
        $key = env('DVLA_SEARCH_KEY');

        /*if ($key) {
            $response = Http::get(
                'https://dvlasearch.appspot.com/AccountInfo',
                [
                    'apikey'       => env('DVLA_SEARCH_KEY'),
                ]
            );

            return $result_json->totalCredits - $result_json->usedCredits;
        }*/

        return 0;
    }

    public function getCredits(): string
    {
        /*$user = env('TEXTMARKETER_USER');
        $pass = env('TEXTMARKETER_PASS');

        if ($user) {
            $URL = 'https://api.textmarketer.co.uk/services/rest/credits' . "?username=" . $user . "&password=" . $pass . "";
            $fp = fopen($URL, 'r');

            return fread($fp, 1024);
        }

        return 0;*/

        $username = config('services.clicksend.username');
        $apiKey = config('services.clicksend.api_key');

        $config = Configuration::getDefaultConfiguration()->setUsername($username)->setPassword($apiKey);
        $apiInstance = new AccountApi(null, $config);

        try {
            $result = json_decode($apiInstance->accountGet());

            return $result->data->_currency->currency_prefix_d . round($result->data->balance, 2) ?? 0;
        } catch (ApiException $e) {
            return 0;
        }
    }
}
