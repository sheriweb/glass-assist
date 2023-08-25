<?php

namespace App\Repositories\Eloquent;

use App\Repositories\WhatWindscreenApiRepositoryInterface;
use GuzzleHttp\Client;

/**
 * Class WhatWindscreenApiRepository
 * @package App\Repositories
 */
class WhatWindscreenApiRepository implements WhatWindscreenApiRepositoryInterface
{

    protected $httpClient;
    protected $baseUrl = 'https://whatwindscreenapi.apex-networks.com/api/lookups';
    protected $headers;


    public function __construct()
    {
        $this->httpClient = new Client();
        $this->headers = [
            'ApiToken'       => env('WHAT_WINDSCREEN_LOOKUP_API_KEY'),
            'ApiAccountCode' => env('WHAT_WINDSCREEN_LOOKUP_API_ACCOUNT_CODE'),
        ];
        //todo api token place here just testing purpose . for later we get from config or env .
    }

    protected function getRequestOptions(array $additionalHeaders = []): array
    {
        return array_merge($this->headers, $additionalHeaders);
    }

    public function get($id)
    {
        $response = $this->httpClient->get($this->baseUrl . '/' . $id, ['headers' => $this->getRequestOptions()]);

        if ($response->getBody()) {
            return response()->json(
                [
                    'status'  => 200,
                    'message' => 'Data fetched successfully.',
                    'data'    => json_decode($response->getBody(), true)
                ]
            );
        }

        return response()->json(
            [
                'status'  => 300,
                'message' => 'Record not found.',
                'data'    => []
            ]
        );
    }

    public function create($request): \Illuminate\Http\JsonResponse
    {
        try {
            $response = $this->httpClient->post(
                $this->baseUrl,
                [
                    'headers' => $this->getRequestOptions(),
                    'json'    => $this->makeRequestData($request),
                ]
            );
            $body = $response->getBody();
            return response()->json(
                [
                    'status'  => 200,
                    'message' => 'New request create successfully.',
                    'data'    => json_decode($body, true)
                ]
            );
        } catch (\Exception $exception) {
            $jsonStartIndex = strpos($exception->getMessage(), '{');
            $jsonResponse = substr($exception->getMessage(), $jsonStartIndex);
            $data = json_decode($jsonResponse, true);
            $errorMessage = $data['modelState']['errors'][0] ?? "Something went wrong please try again..";
            return response()->json(
                [
                    'status'           => 300,
                    'message'          => $exception->getMessage(),
                    'errorMessage'     => $errorMessage,
                    'code'             => $exception->getCode(),
                    'getTraceAsString' => $exception->getTraceAsString(),
                ]
            );
        }
    }

    public function makeRequestData($request): array
    {
        return [
            "glassItem"    => $request->glass_position,
            "vehicleReg"   => $request->vehicle_registration_number,
            "vehicleVIN"   => $request->vin_number,
            "vehicleMake"  => $request->vehicle_make,
            "vehicleModel" => $request->vehicle_model,
            "vehicleYear"  => $request->vehicle_year_manufacture,
        ];
    }

    public function glassPositions()
    {
        try {
            $response = $this->httpClient->get(
                $this->baseUrl . '/listglasspositions',
                [
                    'headers' => $this->getRequestOptions()
                ]
            );

            return [
                'status'  => 200,
                'message' => 'success.',
                'data'    => json_decode($response->getBody(), true)
            ];
        } catch (\Exception $exception) {
            return [
                'status'           => 300,
                'message'          => $exception->getMessage(),
                'code'             => $exception->getCode(),
                'getTraceAsString' => $exception->getTraceAsString(),
            ];
        }
    }
}
