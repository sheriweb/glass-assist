<?php

namespace App\Repositories\Eloquent;

use App\Models\Sent;
use App\Repositories\SentRepositoryInterface;

/**
 * Class SentRepository
 * @package App\Repositories
 */
class SentRepository extends BaseRepository implements SentRepositoryInterface
{
    /**
     * @param Sent $sent
     */
    public function __construct(Sent $sent)
    {
        parent::__construct($sent);
    }
}
