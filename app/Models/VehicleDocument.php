<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VehicleDocument
 *
 * @package App\Models
 * @property string name
 * @property string file_name
 * @property integer status
 * @property-read User|null $user
 * @property-read Vehicle|null $vehicle
 * @method static Builder|VehicleDocument newModelQuery()
 * @method static Builder|VehicleDocument newQuery()
 * @method static Builder|VehicleDocument query()
 * @mixin Eloquent
 */
class VehicleDocument extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles_docs';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_added';

    /**
     * @var string[]
     */
    protected $fillable = [
        'vehicle_id',
        'name',
        'filename',
        'status',
        'date_deleted'
    ];

    /**
     * @return BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
