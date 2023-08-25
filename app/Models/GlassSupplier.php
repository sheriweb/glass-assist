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
 * Class GlassSupplier
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
 * @property int $vat
 * @property int|null $status
 * @property int|null $user_id
 * @property string|null $date_updated
 * @property string|null $date_deleted
 * @property-read User|null $user
 * @property-read Collection|VehicleHistory[] $vehicleHistories
 * @property-read int|null $vehicle_histories_count
 * @method static Builder|GlassSupplier newModelQuery()
 * @method static Builder|GlassSupplier newQuery()
 * @method static Builder|GlassSupplier query()
 * @method static Builder|GlassSupplier whereAddress1($value)
 * @method static Builder|GlassSupplier whereAddress2($value)
 * @method static Builder|GlassSupplier whereCity($value)
 * @method static Builder|GlassSupplier whereCounty($value)
 * @method static Builder|GlassSupplier whereDateAdded($value)
 * @method static Builder|GlassSupplier whereDateDeleted($value)
 * @method static Builder|GlassSupplier whereDateUpdated($value)
 * @method static Builder|GlassSupplier whereEmail($value)
 * @method static Builder|GlassSupplier whereId($value)
 * @method static Builder|GlassSupplier whereName($value)
 * @method static Builder|GlassSupplier wherePhone($value)
 * @method static Builder|GlassSupplier wherePostcode($value)
 * @method static Builder|GlassSupplier whereStatus($value)
 * @method static Builder|GlassSupplier whereUserId($value)
 * @method static Builder|GlassSupplier whereVat($value)
 * @mixin Eloquent
 */
class GlassSupplier extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'glass_suppliers';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_created';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'date_updated';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'address_1',
        'address_2',
        'city',
        'county',
        'postcode',
        'email',
        'phone',
        'vat',
        'status',
        'date_created',
        'date_deleted'
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
    public function vehicleHistories(): HasMany
    {
        return $this->hasMany(VehicleHistory::class, 'user_id', 'user_id');
    }
}
