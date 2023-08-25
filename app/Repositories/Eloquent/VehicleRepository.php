<?php

namespace App\Repositories\Eloquent;

use App\Models\DvlaLookup;
use App\Models\Vehicle;
use App\Repositories\VehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Class VehicleRepository
 * @package App\Repositories
 */
class VehicleRepository extends BaseRepository implements VehicleRepositoryInterface
{
    /**
     * @param Vehicle $vehicle
     */
    public function __construct(Vehicle $vehicle)
    {
        parent::__construct($vehicle);
    }

    /**
     * @inheritDoc
     */
    public function getVehicleMaleModel(array $where = [])
    {
        return Vehicle::query()
            ->leftJoin('car_makes', 'vehicles.make_id', '=', 'car_makes.id')
            ->leftJoin('car_models', 'vehicles.model_id', '=', 'car_models.id')
            ->select("vehicles.id", DB::raw("CONCAT(car_makes.name,' ',car_models.name) AS name"))
            ->where($where)
            ->get();
    }

    public function getDvlaLookupByVehicleReg($vehicleRegNo)
    {
        $vehicleRegNo = strtoupper(preg_replace("/[^A-Za-z0-9]/", '', $vehicleRegNo));
        $dVLALookup = DB::table('dvla_lookups')->where('reg_no', $vehicleRegNo)->first();

        if ($dVLALookup) {
            return response()->json(
                [
                    'status'  => 200,
                    'type'    => 'info',
                    'data'    => $dVLALookup->result,
                    'message' => 'DVLA search successfully done.'
                ]
            );
        } else {
            $response = Http::get(
                'https://dvlasearch.appspot.com/DvlaSearch',
                [
                    'apikey'       => env('DVLA_SEARCH_KEY'),
                    'licencePlate' => $vehicleRegNo,
                ]
            );

            if ($response->successful()) {
                // Request was successful, process the response
                $responseData = $response->json(); // Assuming the response is JSON
                if (isset($responseData['error'])) {
                    return response()->json(
                        [
                            'status'  => 300,
                            'type'    => 'info',
                            'data'    => [],
                            'message' => isset($responseData['message']) ? $responseData['message'] : 'Something went wrong, please try again later.'
                        ]
                    );
                } else {
                    DvlaLookup::create(
                        [
                            'reg_no'    => $vehicleRegNo,
                            'user_id'   => auth()->user()->id,
                            'date_time' => now(),
                            'result'    => $response->body()
                        ]
                    );

                    return response()->json(
                        [
                            'status'  => 200,
                            'type'    => 'info',
                            'data'    => $response->body(),
                            'message' => 'DVLA search successfully done.'
                        ]
                    );
                }
            } else {
                if ($response->clientError()) {
                    return response()->json(
                        [
                            'status'  => 300,
                            'type'    => 'error',
                            'data'    => [],
                            'message' => $response->clientError()
                        ]
                    );
                    // Handle 4xx client errors (e.g., 404 Not Found)
                } elseif ($response->serverError()) {
                    // Handle 5xx server errors (e.g., 500 Internal Server Error)
                    return response()->json(
                        [
                            'status'  => 300,
                            'type'    => 'error',
                            'data'    => [],
                            'message' => 'Internal server error, please try again later.'
                        ]
                    );
                }

                return response()->json(
                    [
                        'status'  => 300,
                        'type'    => 'error',
                        'data'    => [],
                        'message' => $response->body()
                    ]
                );
            }
        }
    }
}
