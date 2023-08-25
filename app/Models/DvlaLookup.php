<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DvlaLookup
 *
 * @package App\Models
 * @property string registration_no
 * @property int $id
 * @property string|null $date_time
 * @property int|null $user_id
 * @property string|null $reg_no
 * @property string|null $result
 * @property int|null $status
 * @property-read User|null $user
 * @method static Builder|DvlaLookup newModelQuery()
 * @method static Builder|DvlaLookup newQuery()
 * @method static Builder|DvlaLookup query()
 * @method static Builder|DvlaLookup whereDateTime($value)
 * @method static Builder|DvlaLookup whereId($value)
 * @method static Builder|DvlaLookup whereRegNo($value)
 * @method static Builder|DvlaLookup whereResult($value)
 * @method static Builder|DvlaLookup whereStatus($value)
 * @method static Builder|DvlaLookup whereUserId($value)
 * @mixin Eloquent
 */
class DvlaLookup extends Model
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
        'date_time',
        'reg_no',
        'result',
        'status',
        'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
