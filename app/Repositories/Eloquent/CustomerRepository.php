<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\CustomerRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerRepository
 * @package App\Repositories
 */
class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }

    /**
     * @inheritDoc
     */
    public function linkVehicle($customerId, $vehicleId, $userId)
    {
        DB::table('customers_vehicles')
            ->insert([
                'customer_id' => $customerId,
                'vehicle_id'  => $vehicleId,
                'date_added'  => Carbon::now(),
                'status'      => 1,
                'user_id'     => $userId
            ]);
    }

    /**
     * @inheritDoc
     */
    public function alreadyLinked($customerId, $vehicleId): Collection
    {
        return DB::table('customers_vehicles')
            ->where(['customer_id' => $customerId, 'vehicle_id' => $vehicleId])
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function setCustomerGroup($customerId, $groupId, $userId)
    {
        DB::table('customers_groups')
            ->insert([
                'customer_id' => $customerId,
                'group_id'    => $groupId,
                'status'      => 1,
                'user_id'     => $userId
            ]);
    }
}
