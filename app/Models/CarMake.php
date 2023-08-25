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
 * Class CarMake
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $user_id
 * @property-read Collection|CarModel[] $carMake
 * @property-read int|null $car_make_count
 * @property-read Collection|CourtesyCar[] $courtesyCars
 * @property-read int|null $courtesy_cars_count
 * @property-read User|null $user
 * @property-read Vehicle|null $vehicle
 * @method static Builder|CarMake newModelQuery()
 * @method static Builder|CarMake newQuery()
 * @method static Builder|CarMake query()
 * @method static Builder|CarMake whereId($value)
 * @method static Builder|CarMake whereName($value)
 * @method static Builder|CarMake whereStatus($value)
 * @method static Builder|CarMake whereUserId($value)
 * @mixin Eloquent
 */
class CarMake extends Model
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

    // NOTE: in the `car_make` there's no `make_id` column
//    public function carModels(): HasMany
//    {
//        return $this->hasMany(CarModel::class, 'make_id', 'id');
//    }

    /**
     * @return HasMany
     */
    public function courtesyCars(): HasMany
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
