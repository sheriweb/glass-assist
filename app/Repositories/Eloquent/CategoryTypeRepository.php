<?php

namespace App\Repositories\Eloquent;

use App\Models\CategoryType;
use App\Repositories\CategoryTypeRepositoryInterface;

/**
 * Class CategoryTypeRepository
 * @package App\Repositories
 */
class CategoryTypeRepository extends BaseRepository implements CategoryTypeRepositoryInterface
{
    /**
     * @param CategoryType $categoryType
     */
    public function __construct(CategoryType $categoryType)
    {
        parent::__construct($categoryType);
    }
}
