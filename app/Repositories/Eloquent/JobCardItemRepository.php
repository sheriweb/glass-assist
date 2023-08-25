<?php

namespace App\Repositories\Eloquent;

use App\Models\JobCardItem;
use App\Repositories\JobCardItemRepositoryInterface;

/**
 * Class JobCardItemRepository
 * @package App\Repositories
 */
class JobCardItemRepository extends BaseRepository implements JobCardItemRepositoryInterface
{
    /**
     * @param JobCardItem $jobCardItem
     */
    public function __construct(JobCardItem $jobCardItem)
    {
        parent::__construct($jobCardItem);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getJobCardItemById($id)
    {
        return JobCardItem::query()->where('history_id', '=', $id)->get();
    }

    /**
     * @param array $data
     * @param $id
     * @return bool|int
     */
    public function updateUsingVehicleHistoryId(array $data, $id)
    {
        return JobCardItem::query()->where('history_id', $id)->update($data);
    }
}
