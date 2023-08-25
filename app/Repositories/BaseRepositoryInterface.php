<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @Class BaseRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @param $request
     * @return mixed
     */
    public function save($request);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function insert(array $attributes);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     * @param int $id
     * @return mixed
     */
    public function update(array $attributes, int $id);

    /**
     * @param array $where
     * @param array $attributes
     * @return mixed
     */
    public function updateWhere(array $where, array $attributes);

    /**
     * @param string $column
     * @param array $values
     * @param array $attributes
     * @return int
     */
    public function updateWhereIn(string $column, array $values, array $attributes): int;

    /**
     * @param array $search
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $search, array $attributes);

    /**
     * @param array $columns
     * @param array $with
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all(array $columns = ['*'], array $with = [], string $orderBy = 'id', string $sortBy = 'desc');

    /**
     * @param array $columns
     * @param array $where
     * @param array $with
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function allWhere(
        array  $columns = ['*'],
        array  $where = [],
        array  $with = [],
        string $orderBy = 'id',
        string $sortBy = 'desc'
    );

    /**
     * @param int $id
     * @param array $with
     * @return mixed
     */
    public function find(int $id, array $with = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function findOneOrFail(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function firstOrCreate(array $data);

    /**
     * @param array $data
     * @param array $with
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function findBy(array $data, array $with = [], string $orderBy = 'id', string $sortBy = 'asc');

    /**
     * @param array $data
     * @param array $with
     * @param array $withCount
     * @return mixed
     */
    public function findOneBy(array $data, array $with = [], array $withCount = []);

    /**
     * @param array $data
     * @param array $with
     * @param array $withCount
     * @return mixed
     */
    public function findOneSoftDeletedRecordBy(array $data, array $with = [], array $withCount = []);

    /**
     * @param string $lookingFor
     * @param string $lookingAt
     * @param mixed $value
     * @return mixed
     */
    public function hasOneEntry(string $lookingFor, string $lookingAt, $value);

    /**
     * @param array $data
     * @return mixed
     */
    public function recordExists(array $data);

    /**
     * @param array $data
     * @param array $with
     * @param string $checkBy
     * @return mixed
     */
    public function findLatestOneBy(array $data, array $with = [], string $checkBy = 'created_at');

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneByOrFail(array $data);

    /**
     * @param int $perPage
     * @param array $where
     * @return mixed
     */
    public function paginateArrayResults(int $perPage = 50, array $where = []);

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @param $column
     * @param string $status
     * @return Builder|Collection
     */
    public function paginate(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage,
        $column,
        string $status = ''
    );

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param string $column
     * @param array $data
     * @return bool
     */
    public function deleteWhereIn(string $column, array $data): bool;

    /**
     * @param string $column
     * @param array $data
     * @param array $with
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function whereIn(string $column, array $data, array $with = [], string $orderBy = 'id', string $sortBy = 'asc');

    /**
     * @param string $attribute
     * @param mixed $value
     * @param int $limit
     * @param array $columns
     * @return mixed
     */
    public function findWhereLike(string $attribute, $value, int $limit = 10, array  $columns = ['*']);

    /**
     * @return mixed
     */
    public function newModelInstance();

    /**
     * @return int
     */
    public function counts(): int;

    /**
     * @return Builder[]|Collection
     */
    public function getAllAndName();

    /**
     * @param string $column
     * @param string $value
     * @return int
     */
    public function whereLikeCount(string $column, string $value): int;
}
