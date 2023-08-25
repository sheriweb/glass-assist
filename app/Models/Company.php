<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Company
 *
 * @package App\Models
 * @property int $id
 * @property string|null $name
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $postcode
 * @property string|null $email
 * @property string|null $phone
 * @property int|null $status
 * @property int|null $user_id
 * @property string|null $date_added
 * @property string|null $date_updated
 * @property string|null $date_deleted
 * @property-read Collection|Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read User|null $user
 * @property-read Collection|VehicleHistory[] $vehicleHistories
 * @property-read int|null $vehicle_histories_count
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereAddress1($value)
 * @method static Builder|Company whereAddress2($value)
 * @method static Builder|Company whereCity($value)
 * @method static Builder|Company whereCounty($value)
 * @method static Builder|Company whereDateAdded($value)
 * @method static Builder|Company whereDateDeleted($value)
 * @method static Builder|Company whereDateUpdated($value)
 * @method static Builder|Company whereEmail($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company wherePhone($value)
 * @method static Builder|Company wherePostcode($value)
 * @method static Builder|Company whereStatus($value)
 * @method static Builder|Company whereUserId($value)
 * @mixin Eloquent
 */
class Company extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_added';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'date_updated';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'county',
        'address_1',
        'address_2',
        'city',
        'postcode',
        'status',
        'parent_company_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * @return HasMany
     */
    public function vehicleHistories(): HasMany
    {
        return $this->hasMany(VehicleHistory::class);
    }
}
