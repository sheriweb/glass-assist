<?php

namespace App\Repositories\Eloquent;

use App\Models\Company;
use App\Repositories\CompanyRepositoryInterface;

/**
 * Class CustomerRepository
 * @package App\Repositories
 */
class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    /**
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        parent::__construct($company);
    }
}
