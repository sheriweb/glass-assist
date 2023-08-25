<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param $user
     * @param $request
     * @return mixed
     */
    public function commonField($user, $request)
    {
        $user->first_name = $request->first_name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->email = $request->email;
        if (!$request->user_id) {
            $user->password = $request->password;
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getByField($field, $value)
    {
        return User::{'where' . ucfirst($field)}($value)->first();
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return User::query()
            ->select("*", DB::raw("CONCAT(users.first_name,' ',users.surname) AS name"))
            ->get();
    }

    /**
     * @return User[]|Builder[]|Collection
     */
    public function getTechnicians()
    {
        return User::query()
            ->where('access_level', '=', 5)
            ->where('status','=', 1)
            ->where('username', 'not like', "%unalloc%")
            ->get();
    }
}
