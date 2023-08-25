<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class VehicleMaintenanceEventAttachment
 *
 * @package App\Models
 * @property int $id
 * @property int|null $vehicle_maintenance_event_id
 * @property string|null $file_name
 * @property-read VehicleMaintenanceEvent|null $vehicleMaintenanceEvent
 * @method static Builder|VehicleMaintenanceEventAttachment newModelQuery()
 * @method static Builder|VehicleMaintenanceEventAttachment newQuery()
 * @method static Builder|VehicleMaintenanceEventAttachment query()
 * @method static Builder|VehicleMaintenanceEventAttachment whereFileName($value)
 * @method static Builder|VehicleMaintenanceEventAttachment whereId($value)
 * @method static Builder|VehicleMaintenanceEventAttachment whereVehicleMaintenanceEventId($value)
 * @mixin Eloquent
 */
class VehicleMaintenanceEventAttachment extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'file_name',
        'vehicle_maintenance_event_id'
    ];

    /**
     * @return HasMany
     */
    public function vehicleMaintenanceEvent(): HasMany
    {
        return $this->hasMany(VehicleMaintenanceEvent::class);
    }
}
