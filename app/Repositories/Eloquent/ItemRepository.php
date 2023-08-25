<?php

namespace App\Repositories\Eloquent;

use App\Models\Item;
use App\Repositories\ItemRepositoryInterface;

/**
 * Class ItemRepository
 * @package App\Repositories
 */
class ItemRepository extends BaseRepository implements ItemRepositoryInterface
{
    /**
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        parent::__construct($item);
    }
}
