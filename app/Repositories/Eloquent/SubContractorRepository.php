<?php

namespace App\Repositories\Eloquent;

use App\Models\SubContractor;
use App\Repositories\SubContractorRepositoryInterface;

/**
 * Class SubContractorRepository
 * @package App\Repositories
 */
class SubContractorRepository extends BaseRepository implements SubContractorRepositoryInterface
{
    /**
     * @param SubContractor $subContractor
     */
    public function __construct(SubContractor $subContractor)
    {
        parent::__construct($subContractor);
    }
}
