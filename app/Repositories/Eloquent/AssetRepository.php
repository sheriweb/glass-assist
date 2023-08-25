<?php

namespace App\Repositories\Eloquent;

use App\Models\Asset;
use App\Repositories\AssetRepositoryInterface;

/**
 * Class AssetRepository
 * @package App\Repositories
 */
class AssetRepository extends BaseRepository implements AssetRepositoryInterface
{
    /**
     * @param Asset $asset
     */
    public function __construct(Asset $asset)
    {
        parent::__construct($asset);
    }
}
