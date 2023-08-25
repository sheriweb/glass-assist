<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @Class UserRepositoryInterface
 * @package App\Repositories
 */
interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function getByField($field, $value);

    /**
     * @return User[]|Builder[]|Collection
     */
    public function getAll();
}
