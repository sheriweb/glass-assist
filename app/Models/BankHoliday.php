<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BankHoliday
 *
 * @package App\Models
 * @property string from_date
 * @property string to_date
 * @property int $id
 * @property int|null $user_id
 * @property string|null $date_from
 * @property string|null $date_to
 * @property int $status
 * @property string|null $details
 * @property-read User|null $user
 * @method static Builder|BankHoliday newModelQuery()
 * @method static Builder|BankHoliday newQuery()
 * @method static Builder|BankHoliday query()
 * @method static Builder|BankHoliday whereDateFrom($value)
 * @method static Builder|BankHoliday whereDateTo($value)
 * @method static Builder|BankHoliday whereDetails($value)
 * @method static Builder|BankHoliday whereId($value)
 * @method static Builder|BankHoliday whereStatus($value)
 * @method static Builder|BankHoliday whereUserId($value)
 * @mixin Eloquent
 */
class BankHoliday extends Model
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
        'date_from',
        'date_to',
        'details',
        'status'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
