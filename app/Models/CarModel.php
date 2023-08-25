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
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class CarModel
 *
 * @package App\Models
 * @property int $id
 * @property int $make_id
 * @property string $name
 * @property int $status
 * @property int $user_id
 * @property-read CarMake|null $carMake
 * @property-read Vehicle|null $carModel
 * @property-read Collection|CourtesyCar[] $courtesyCar
 * @property-read int|null $courtesy_car_count
 * @property-read User|null $user
 * @method static Builder|CarModel newModelQuery()
 * @method static Builder|CarModel newQuery()
 * @method static Builder|CarModel query()
 * @method static Builder|CarModel whereId($value)
 * @method static Builder|CarModel whereMakeId($value)
 * @method static Builder|CarModel whereName($value)
 * @method static Builder|CarModel whereStatus($value)
 * @method static Builder|CarModel whereUserId($value)
 * @mixin Eloquent
 */
class CarModel extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'make_id',
        'name',
        'status'
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
    public function carMake(): BelongsTo
    {
        return $this->belongsTo(CarMake::class, 'make_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function courtesyCar(): HasMany
    {
        return $this->hasMany(CourtesyCar::class);
    }

    /**
     * @return HasOne
     */
    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class);
    }
}
