<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\SettingRepositoryInterface;

/**
 * Class SettingRepository
 * @package App\Repositories
 */
class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    /**
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        parent::__construct($setting);
    }

}
