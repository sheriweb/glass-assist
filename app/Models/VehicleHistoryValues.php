<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VehicleHistoryValues
 *
 * @package App\Models
 * @property string field_name
 * @property string field_value
 * @property string field_value_long
 * @property integer status
 * @property-read Vehicle|null $vehicle
 * @method static Builder|VehicleHistoryValues newModelQuery()
 * @method static Builder|VehicleHistoryValues newQuery()
 * @method static Builder|VehicleHistoryValues query()
 * @mixin Eloquent
 */
class VehicleHistoryValues extends Model
{
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_added';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles_history_values';

    /**
     * @var string[]
     */
    protected $fillable = [
        'vh_id',
        'field_name',
        'field_value',
        'field_value_long',
        'status',
        'date_deleted'
    ];

    /**
     * @return BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vh_id', 'id');
    }
}
