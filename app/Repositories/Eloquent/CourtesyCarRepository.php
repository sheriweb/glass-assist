<?php

namespace App\Repositories\Eloquent;

use App\Models\CourtesyCar;
use App\Repositories\CourtesyCarRepositoryInterface;

/**
 * Class CourtesyCarRepository
 * @package App\Repositories
 */
class CourtesyCarRepository extends BaseRepository implements CourtesyCarRepositoryInterface
{
    /**
     * @param CourtesyCar $courtesyCar
     */
    public function __construct(CourtesyCar $courtesyCar)
    {
        parent::__construct($courtesyCar);
    }
}
