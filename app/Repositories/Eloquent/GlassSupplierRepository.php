<?php

namespace App\Repositories\Eloquent;

use App\Models\GlassSupplier;
use App\Repositories\GlassSupplierRepositoryInterface;

/**
 * Class GlassSupplierRepository
 * @package App\Repositories
 */
class GlassSupplierRepository extends BaseRepository implements GlassSupplierRepositoryInterface
{
    /**
     * @param GlassSupplier $glassSupplier
     */
    public function __construct(GlassSupplier $glassSupplier)
    {
        parent::__construct($glassSupplier);
    }
}
