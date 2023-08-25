<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Holiday
 *
 * @package App\Models
 * @property int $id
 * @property int|null $user_id
 * @property string|null $type
 * @property string|null $ampm
 * @property int|null $staff_id
 * @property string|null $date_from
 * @property string|null $date_to
 * @property int $status
 * @property string|null $details
 * @property-read Staff|null $staff
 * @property-read User|null $user
 * @method static Builder|Holiday newModelQuery()
 * @method static Builder|Holiday newQuery()
 * @method static Builder|Holiday query()
 * @method static Builder|Holiday whereAmpm($value)
 * @method static Builder|Holiday whereDateFrom($value)
 * @method static Builder|Holiday whereDateTo($value)
 * @method static Builder|Holiday whereDetails($value)
 * @method static Builder|Holiday whereId($value)
 * @method static Builder|Holiday whereStaffId($value)
 * @method static Builder|Holiday whereStatus($value)
 * @method static Builder|Holiday whereType($value)
 * @method static Builder|Holiday whereUserId($value)
 * @mixin Eloquent
 */
class Holiday extends Model
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
        'type',
        'ampm',
        'staff_id',
        'date_from',
        'date_to',
        'status',
        'details'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function staff(): BelongsTo // TODO: staffs
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
