<?php

namespace App\Services;

use App\Helpers\BasicHelpers;
use App\Models\User;
use App\Models\VehicleHistory;
use App\Repositories\Eloquent\VehicleHistoryRepository;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * UserRepositoryInterface depend injection.
     *
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var VehicleHistoryRepository
     */
    private $vehicleHistoryRepository;

    public function __construct(UserRepositoryInterface $userRepository, VehicleHistoryRepository $vehicleHistoryRepository)
    {
        $this->userRepository = $userRepository;
        $this->vehicleHistoryRepository = $vehicleHistoryRepository;
    }

    /**
     * @param array $data
     * @return Builder|Model|object|User
     * @throws Exception
     */
    public function login(array $data)
    {
        $user = $this->userRepository->getByField('username', $data['email']);

        if (!$user ||
            !(BasicHelpers::encryptPassword($data['password'], $user->password_salt) === $user->password)) {
            throw new Exception('Username/Password wrong.', 401);
        }

        return $user;
    }

    /**
     * @param array $data
     * @return Builder|Model|object|User
     * @throws Exception
     */
    public function create(array $data)
    {
        $userExists = $this->userRepository->getByField('email', $data['email']);

        if (isset($userExists)) {
            throw new Exception('Email already in use');
        }

        $userExists = $this->userRepository->getByField('username', $data['username']);

        if (isset($userExists)) {
            throw new Exception('Username already in use');
        }

        return $this->userRepository->create($data);
    }

    /**
     * @return Builder[]|Collection|User[]
     */
    public function getTechnicians()
    {
        return $this->userRepository->allWhere(['id', DB::raw("CONCAT(first_name, ' ', surname) as name")], ['access_level' => 5]);
    }

    /**
     * @param $date
     * @return Builder[]|Collection|VehicleHistory[]
     */
    public function getTechnicianHistory($date)
    {
        return $this->vehicleHistoryRepository->technicianHistory($date);
    }
}
