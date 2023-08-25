<?php

namespace App\Services;

use App\Helpers\StaticMessages;
use App\Models\VehicleHistory;
use App\Repositories\JobCardItemRepositoryInterface;
use App\Repositories\VehicleHistoryDocsRepositoryInterface;
use App\Repositories\VehicleHistoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BookingService
 * @package App\Services
 */
class BookingService
{
    /**
     * BookingsRepositoryInterface depend injection.
     *
     * @var VehicleHistoryRepositoryInterface
     */
    private $vehicleHistoryRepository;

    /**
     * JobCardItemRepositoryInterface depend injection.
     *
     * @var JobCardItemRepositoryInterface
     */
    private $jobCardItemRepository;

    /**
     * VehicleHistoryDocsRepositoryInterface depend injection.
     *
     * @var VehicleHistoryDocsRepositoryInterface
     */
    private $vehicleHistoryDocsRepository;

    public function __construct(
        VehicleHistoryRepositoryInterface $vehicleHistoryRepository,
        JobCardItemRepositoryInterface $jobCardItemRepository,
        VehicleHistoryDocsRepositoryInterface $vehicleHistoryDocsRepository
    ) {
        $this->vehicleHistoryRepository = $vehicleHistoryRepository;
        $this->jobCardItemRepository = $jobCardItemRepository;
        $this->vehicleHistoryDocsRepository = $vehicleHistoryDocsRepository;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleHistoryById($id)
    {
        return $this->vehicleHistoryRepository->getVehicleHistoryById($id);
    }

    /**
     * @param $type
     * @param string $startDate
     * @param string $endData
     * @return VehicleHistory[]|Builder[]|Collection
     */
    public function getVehicleHistoryByWeek(string $type, string $startDate, string $endData)
    {
        return $this->vehicleHistoryRepository->findByCalendarDateTime($type, $startDate, $endData);
    }

    /**
     * @param string $startDate
     * @param string $endData
     * @return Builder[]|Collection|VehicleHistory[]
     */
    public function getAllVehicleHistoryByMonth(string $startDate, string $endData)
    {
        return $this->vehicleHistoryRepository->getAllByDate($startDate, $endData);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createBooking(array $data)
    {
        return $this->vehicleHistoryRepository->create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createJobCardItem(array $data)
    {
        return $this->jobCardItemRepository->create($data);
    }

    public function getJobCardItemById($id)
    {
        return $this->jobCardItemRepository->getJobCardItemById($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function newVehicleHistoryDocs(array $data)
    {
        return $this->vehicleHistoryDocsRepository->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function updateVehicleHistory(array $data, $id)
    {
        return $this->vehicleHistoryRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleHistory($id)
    {
        return $this->vehicleHistoryRepository->getVehicleHistory($id);
    }

    /**
     * @return mixed
     */
    public function getAllUnallocatedVehicleHistories()
    {
        return $this->vehicleHistoryRepository->allWhere(['*'], ['datetime' => null]);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateBooking(array $data, int $id)
    {
        return $this->vehicleHistoryRepository->update($data, $id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function removeBooking(int $id)
    {
        return $this->vehicleHistoryRepository->delete($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool|int
     */
    public function updateJobCardItem(array $data, int $id)
    {
        return $this->jobCardItemRepository->updateUsingVehicleHistoryId($data, $id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveSignature($request)
    {
        $folderPath = public_path('upload/signatures/');
        $image_parts = explode(";base64,", $request->signature);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $name = uniqid();
        $file = $folderPath . $name . '.' . $image_type;
        file_put_contents($file, $image_base64);
        $signature = $name . '.' . $image_type;

        $vehicleHistory = VehicleHistory::where('id', '=', $request->vehicleHistoryId)->first();
        $vehicleHistory->signature = $signature;

        $vehicleHistory->update();

        return response()->json(
            [
                'id'         => $vehicleHistory->id,
                'message'    => StaticMessages::$UPDATED,
                'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
            ]
        );
    }

    /**
     * @param $searchValue
     * @return int
     */
    public function getVehicleHistoriesCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->vehicleHistoryRepository->whereLikeCount('id', $searchValue);
        }

        return $this->vehicleHistoryRepository->counts();
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder[]|Collection
     */
    public function getVehicleHistoriesPaginator(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    ) {
        return $this->vehicleHistoryRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'id'
        );
    }

    /**
     * @param $postcode
     * @return array
     */
    public function getLngLatFromPostcode($postcode): array
    {
        $lat = 0;
        $lng = 0;
        $searchCode = urlencode($postcode);
        $url = "https://nominatim.openstreetmap.org/search?format=json&postalcode=" . $searchCode;
        $httpOptions = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: Nominatim-Test"
            ]
        ];
        $streamContext = stream_context_create($httpOptions);
        $json = file_get_contents($url, false, $streamContext);
        $decoded = json_decode($json, true);

        if (!empty($decoded)) {
            $lat = $decoded[0]["lat"];
            $lng = $decoded[0]["lon"];
        }

        return ['lat' => $lat, 'lng' => $lng];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTechnicianBookings($id)
    {
        return $this->vehicleHistoryRepository->allWhere(['*'], ['technician' => $id]);
    }

    /**
     * @param $technicianId
     * @param $date
     * @return mixed
     */
    public function getTechnicianBookingsByDate($technicianId, $date)
    {
        return $this->vehicleHistoryRepository->getTechnicianBookingsByDate($technicianId, $date);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateTechnicianVehicleHistory($request)
    {
        return $this->vehicleHistoryRepository->updateTechnicianVehicleHistory($request);
    }
}
