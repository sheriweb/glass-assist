<?php

namespace App\Services;

use App\Repositories\GroupMailRepositoryInterface;

/**
 * Class GroupEmailService
 * @package App\Services
 */
class GroupEmailService
{
    /**
     * GroupMailRepositoryInterface depend injection.
     *
     * @var GroupMailRepositoryInterface
     */
    private $groupMailRepository;

    public function __construct(GroupMailRepositoryInterface $groupMailRepository)
    {
        $this->groupMailRepository = $groupMailRepository;
    }

    /**
     * @return mixed
     */
    public function getGroupEmailsPaginator()
    {
        return $this->groupMailRepository->paginateArrayResults();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createGroupEmail($data)
    {
        return $this->groupMailRepository->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return void
     */
    public function updateGroupEmail($id, $data)
    {
        $this->groupMailRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getGroupEmail($id)
    {
        return $this->groupMailRepository->find($id);
    }
}
