<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class VehicleMaintenanceEvent
 *
 * @package App\Models
 * @property string start_date
 * @property string end_date
 * @property string schedule_time
 * @property string service_type
 * @property string note
 * @property integer const
 * @property string invoice_reference
 * @property-read Collection|VehicleMaintenanceEventAttachment[] $vehicleMaintenanceEventAttachment
 * @property-read int|null $vehicle_maintenance_event_attachment_count
 * @property-read VehicleMaintenance|null $vehicleMaintenance
 * @method static Builder|VehicleMaintenanceEvent newModelQuery()
 * @method static Builder|VehicleMaintenanceEvent newQuery()
 * @method static Builder|VehicleMaintenanceEvent query()
 * @mixin Eloquent
 */
class VehicleMaintenanceEvent extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicle_maintenance_event';

    /**
     * @var string[]
     */
    protected $fillable = [
        'vehicle_maintenance_id',
        'start_date',
        'end_date',
        'schedule_time',
        'service_type',
        'note',
        'cost',
        'invoice_ref',
        'event_completed',
        'status'
    ];

    /**
     * @return BelongsTo
     */
    public function vehicleMaintenance(): BelongsTo
    {
        return $this->belongsTo(VehicleMaintenance::class,'vehicle_maintenance_id','id');
    }

    /**
     * @return BelongsTo
     */
    public function vehicleMaintenanceEventAttachment(): BelongsTo
    {
        return $this->belongsTo(VehicleMaintenanceEventAttachment::class);
    }
}
