<?php

namespace App\Services;

use App\Models\VehicleMaintenanceEventAttachment;
use App\Repositories\Eloquent\VehicleMaintenanceEventAttachmentRepository;
use App\Repositories\VehicleMaintenanceEventRepositoryInterface;
use App\Repositories\VehicleMaintenanceRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehicleManagementService
 * @package App\Services
 */
class VehicleManagementService
{
    /**
     * VehicleMaintenanceRepositoryInterface depend injection.
     *
     * @var VehicleMaintenanceRepositoryInterface
     */
    private $vehicleMaintenanceRepository;

    /**
     * VehicleMaintenanceRepositoryInterface depend injection.
     *
     * @var VehicleMaintenanceEventRepositoryInterface
     */
    private $vehicleMaintenanceEventRepository;
    /**
     * @var VehicleMaintenanceEventAttachmentRepository
     */
    private $vehicleMaintenanceEventAttachmentRepository;

    public function __construct(
        VehicleMaintenanceRepositoryInterface $vehicleMaintenanceRepository,
        VehicleMaintenanceEventRepositoryInterface $vehicleMaintenanceEventRepository,
        VehicleMaintenanceEventAttachmentRepository $vehicleMaintenanceEventAttachmentRepository
    ) {
        $this->vehicleMaintenanceRepository = $vehicleMaintenanceRepository;
        $this->vehicleMaintenanceEventRepository = $vehicleMaintenanceEventRepository;
        $this->vehicleMaintenanceEventAttachmentRepository = $vehicleMaintenanceEventAttachmentRepository;
    }

    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    public function getVehicleManagementDue($start, $end)
    {
        return $this->vehicleMaintenanceRepository->getDue($start, $end);
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getVehicleManagementOverDue($date)
    {
        return $this->vehicleMaintenanceRepository->getOverDue($date);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createVehicleManagement(array $data)
    {
        return $this->vehicleMaintenanceRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateVehicleManagement($id, $data)
    {
        return $this->vehicleMaintenanceRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVehicleManagementById($id)
    {
        return $this->vehicleMaintenanceRepository->find($id);
    }

    /**
     * @return mixed
     */
    public function getVehicleManagements()
    {
        return $this->vehicleMaintenanceRepository->getAllStatus();
    }

    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    public function getVehicleEventsDue($start, $end)
    {
        return $this->vehicleMaintenanceEventRepository->getDue($start, $end);
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getVehicleEventsOverDue($date)
    {
        return $this->vehicleMaintenanceEventRepository->getOverDue($date);
    }

    public function getVehicleEventById($id)
    {
       return $this->vehicleMaintenanceEventRepository->getVehicleEventById($id);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateVehicleEvent($data, $id)
    {
        return $this->vehicleMaintenanceEventRepository->update($data,$id);
    }

    /**
     * @param $id
     * @return Builder[]|Collection|VehicleMaintenanceEventAttachment[]
     */
    public function findAttachment($id)
    {
        return $this->vehicleMaintenanceEventAttachmentRepository->findAttachment($id);
    }

    /**
     * @param $data
     * @return bool|mixed
     */
    public function addVehicleEventAttachment($data)
    {
        return $this->vehicleMaintenanceEventAttachmentRepository->insert($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateVehicleEventAttachment($data, $id)
    {
        return $this->vehicleMaintenanceEventAttachmentRepository->update($data, $id);
    }
}
