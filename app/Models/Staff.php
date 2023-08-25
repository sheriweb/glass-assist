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
 * Class Staff
 *
 * @package App\Models
 * @property integer holiday_entitlement_2025
 * @property integer holiday_entitlement_2026
 * @property integer holiday_entitlement_2027
 * @property integer holiday_entitlement_2028
 * @property integer holiday_entitlement_2029
 * @property integer holiday_entitlement_2030
 * @property int $id
 * @property string|null $first_name
 * @property string|null $surname
 * @property string|null $position
 * @property string|null $holiday_entitlement_2016
 * @property string|null $holiday_entitlement_2017
 * @property string|null $holiday_entitlement_2018
 * @property string|null $holiday_entitlement_2019
 * @property string|null $holiday_entitlement_2020
 * @property string|null $holiday_entitlement_2021
 * @property string|null $holiday_entitlement_2022
 * @property string|null $holiday_entitlement_2023
 * @property string|null $holiday_entitlement_2024
 * @property int|null $user_id
 * @property int|null $status
 * @property-read Collection|Holiday[] $holidays
 * @property-read int|null $holidays_count
 * @property-read User|null $user
 * @property-read Collection|VehicleSale[] $vehicleSales
 * @property-read int|null $vehicle_sales_count
 * @method static Builder|Staff newModelQuery()
 * @method static Builder|Staff newQuery()
 * @method static Builder|Staff query()
 * @method static Builder|Staff whereFirstName($value)
 * @method static Builder|Staff whereHolidayEntitlement2016($value)
 * @method static Builder|Staff whereHolidayEntitlement2017($value)
 * @method static Builder|Staff whereHolidayEntitlement2018($value)
 * @method static Builder|Staff whereHolidayEntitlement2019($value)
 * @method static Builder|Staff whereHolidayEntitlement2020($value)
 * @method static Builder|Staff whereHolidayEntitlement2021($value)
 * @method static Builder|Staff whereHolidayEntitlement2022($value)
 * @method static Builder|Staff whereHolidayEntitlement2023($value)
 * @method static Builder|Staff whereHolidayEntitlement2024($value)
 * @method static Builder|Staff whereId($value)
 * @method static Builder|Staff wherePosition($value)
 * @method static Builder|Staff whereStatus($value)
 * @method static Builder|Staff whereSurname($value)
 * @method static Builder|Staff whereUserId($value)
 * @mixin Eloquent
 */
class Staff extends Model
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
        'first_name',
        'surname',
        'position',
        'holiday_entitlement_2016',
        'holiday_entitlement_2017',
        'holiday_entitlement_2018',
        'holiday_entitlement_2019',
        'holiday_entitlement_2020',
        'holiday_entitlement_2021',
        'holiday_entitlement_2022',
        'holiday_entitlement_2023',
        'holiday_entitlement_2024',
        'status'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function holiday(): BelongsTo
    {
        return $this->belongsTo(Holiday::class);
    }

    /**
     * @return HasMany
     */
    public function vehicleSales(): HasMany
    {
        return $this->hasMany(VehicleSale::class);
    }
}
