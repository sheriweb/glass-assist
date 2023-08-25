<?php

namespace App\Repositories\Eloquent;

use App\Models\GroupMail;
use App\Repositories\GroupMailRepositoryInterface;

/**
 * Class GroupMailRepository
 * @package App\Repositories
 */
class GroupMailRepository extends BaseRepository implements GroupMailRepositoryInterface
{
    /**
     * @param GroupMail $groupMail
     */
    public function __construct(GroupMail $groupMail)
    {
        parent::__construct($groupMail);
    }
}
