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
 * Class VehicleMaintenance
 *
 * @package App\Models
 * @property string make
 * @property string model
 * @property string registration
 * @property string vin_number
 * @property string date_of_purchase
 * @property string mot_date
 * @property string service_date
 * @property string warranty_date
 * @property string insurance_date
 * @property integer status
 * @property-read User|null $user
 * @property-read Collection|VehicleMaintenanceEvent[] $vehicleMaintenanceEvents
 * @property-read int|null $vehicle_maintenance_events_count
 * @method static Builder|VehicleMaintenance newModelQuery()
 * @method static Builder|VehicleMaintenance newQuery()
 * @method static Builder|VehicleMaintenance query()
 * @mixin Eloquent
 */
class VehicleMaintenance extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicle_maintenance';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'make',
        'model',
        'reg',
        'vin_number',
        'date_of_purchase',
        'mot_date',
        'service_date',
        'warranty_date',
        'insurance_date',
        'status',
        'linked_user_id',
        'tyre_size'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * @return HasMany
     */
    public function vehicleMaintenanceEvents(): HasMany
    {
        return $this->hasMany(VehicleMaintenanceEvent::class);
    }
}
