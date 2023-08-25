<?php

namespace App\Repositories;

/**
 * @Class GroupRepositoryInterface
 * @package App\Repositories
 */
interface GroupRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $id
     * @return array
     */
    public function getArchivedGroups($id): array;
}
