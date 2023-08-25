<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function save($request)
    {
        return $this->model->save($request);
    }

    /**
     * @inheritDoc
     */
    public function insert(array $attributes)
    {
        return $this->model->query()->insert($attributes);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes)
    {
        return $this->model::query()->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(array $attributes, int $id)
    {
        return tap($this->model::query()->find($id))->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function updateWhere(array $where, array $attributes)
    {
        return $this->model::query()->where($where)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function updateWhereIn(string $column, array $values, array $attributes): int
    {
        return $this->model::query()->whereIn($column, $values)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function updateOrCreate(array $search, array $attributes)
    {
        return $this->model::query()->updateOrCreate($search, $attributes);
    }

    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*'], array $with = [], string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model->with($with)->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function allWhere(
        array $columns = ['*'],
        array $where = [],
        array $with = [],
        string $orderBy = 'id',
        string $sortBy = 'desc'
    ) {
        return $this->model->query()->select($columns)
            ->where($where)
            ->with($with)
            ->orderBy($orderBy, $sortBy)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function find(int $id, array $with = [])
    {
        return $this->model->with($with)->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findOneOrFail(int $id)
    {
        return $this->model::query()->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function firstOrCreate(array $data)
    {
        return $this->model::query()->firstOrCreate($data);
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $data, array $with = [], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model::query()->where($data)->with($with)->orderBy($orderBy, $sortBy)->get();
    }

    /**
     * @inheritDoc
     */
    public function findOneBy(array $data, array $with = [], array $withCount = [])
    {
        return $this->model::query()->where($data)->with($with)->withCount($withCount)->first();
    }

    /**
     * @inheritDoc
     */
    public function findOneSoftDeletedRecordBy(array $data, array $with = [], array $withCount = [])
    {
        return $this->model::query()->withTrashed()->where($data)->with($with)->withCount($withCount)->first();
    }

    /**
     * @inheritDoc
     */
    public function hasOneEntry(string $lookingFor, string $lookingAt, $value)
    {
        return $this->model::query()->select($lookingFor)->where($lookingAt, $value)->count() > 0 ? 1 : 0;
    }

    /**
     * @inheritDoc
     */
    public function recordExists(array $data)
    {
        return $this->model->query()->where($data)->exists();
    }

    /**
     * @inheritDoc
     */
    public function findLatestOneBy(array $data, array $with = [], string $checkBy = 'created_at')
    {
        return $this->model::query()->where($data)->with($with)->latest($checkBy)->first();
    }

    /**
     * @inheritDoc
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model::query()->where($data)->firstOrFail();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function paginateArrayResults(int $perPage = 50, array $where = [])
    {
        return $this->model::query()->where($where)->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return $this->model::query()->find($id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function deleteWhereIn(string $column, array $data): bool
    {
        return $this->model::query()->whereIn($column, $data)->delete();
    }

    /**
     * @inheritDoc
     */
    public function whereIn(
        string $column,
        array $data,
        array $with = [],
        string $orderBy = 'id',
        string $sortBy = 'asc'
    ) {
        return $this->model::query()->whereIn($column, $data)->with($with)->orderBy($orderBy, $sortBy)->get();
    }

    /**
     * @inheritDoc
     */
    public function findWhereLike(string $attribute, $value, int $limit = 10, array $columns = ['*'])
    {
        $collection = $this->model->query();

        if (!blank($value)) {
            $collection->where($attribute, 'LIKE', "%{$value}%");
        }

        // bring back all results
        if ($limit != 0) {
            $collection->limit($limit);
        }

        return $collection->select($columns)->orderBy($attribute)->get();
    }

    /**
     * @inheritDoc
     */
    public function newModelInstance()
    {
        return new $this->model();
    }

    /**
     * @inheritDoc
     */
    public function counts(): int
    {
        return $this->model::query()->count();
    }

    /**
     * @inheritDoc
     */
    public function getAllAndName()
    {
        // table name
        $table = $this->model->getTable();

        return $this->model::query()
            ->select('*', DB::raw("CONCAT(" . $table . ".first_name,' '," . $table . ".surname) AS name"))
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function whereLikeCount(string $column, string $value): int
    {
        return $this->model::query()
            ->select('count(*) as allcount')
            ->whereLike($column, $value)
            ->count();
    }

    /**
     * @inheritDoc
     */
    public function paginate(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage,
        $column,
        string $status = 'status'
    ) {
        // table name
        $table = $this->model->getTable();

        return $this->model::query()
            ->orderBy($columnName, $columnSortOrder)
            ->where($table . '.' . $column, 'like', '%' . $searchValue . '%')
            ->where($status, '!=', 0)
            ->skip($start)
            ->take($rowPerPage)
            ->get();
    }
}
