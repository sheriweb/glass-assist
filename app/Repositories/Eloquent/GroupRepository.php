<?php

namespace App\Repositories\Eloquent;

use App\Models\Group;
use App\Repositories\GroupRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use function Clue\StreamFilter\fun;

/**
 * Class GroupRepository
 * @package App\Repositories
 */
class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{
    /**
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        parent::__construct($group);
    }

    /**
     * @inheritDoc
     */
    public function getArchivedGroups($id): array
    {
//        $counts = DB::table('groups', 'g')
//            ->join('customers_groups as cg', function ($join) {
//                $join->on('g.user_id', '=', 'cg.user_id')
//                    ->on('cg.group_id', '=', 'g.id');
//            })
//            ->where('cg.status', '=', 1)
//            ->count('cp.id');
//
//        $textsCount = DB::table('groups', 'g')
//            ->join('customers as c', 'g.user_id', '=', 'c.user_id')
//            ->where('g.status', '=', 1)
//            ->where('c.send_text', '=', 1)
//            ->count('g.id');
//
//        $emailsCount = DB::table('groups', 'g')
//            ->join('customers as c', 'g.user_id', '=', 'c.user_id')
//            ->where('g.status', '=', 1)
//            ->where('c.send_email', '=', 1)
//            ->count('g.id');

        return DB::select(
            "
            SELECT g.*,
            (
                select count(cg.id) as count
                from customers_groups cg
                where cg.group_id = g.id and cg.status = 1 and cg.user_id = ?
            )
            as count,
            (
                select count(cg.id) as count
                from customers_groups cg
                left join customers c on c.id = cg.customer_id
                where cg.group_id = g.id and cg.status = 1 and cg.user_id = ?
                and c.status = 1
                AND c.send_text = 1
                AND LENGTH(c.mobile) = 12
            )
            as eligible_text,
            (
                select count(cg.id) as count
                from customers_groups cg
                left join customers c on c.id = cg.customer_id
                where cg.group_id = g.id and cg.status = 1 and cg.user_id = ?
                and c.status = 1
                AND c.send_email = 1
                AND LENGTH(c.email) > 0
            )
            as eligible_email FROM `groups` g WHERE g.status = ? AND g.user_id = ?
            ",
            [$id, $id, $id, 1, $id]
        );
    }
}
