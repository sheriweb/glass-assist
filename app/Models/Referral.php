<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Referral
 *
 * @package App\Models
 * @property int $id
 * @property string|null $code
 * @property int|null $user_id
 * @property int|null $sign_up_fee
 * @property int|null $monthly_fee
 * @property int|null $account_level
 * @property string|null $date_added
 * @property-read User|null $user
 * @method static Builder|Referral newModelQuery()
 * @method static Builder|Referral newQuery()
 * @method static Builder|Referral query()
 * @method static Builder|Referral whereAccountLevel($value)
 * @method static Builder|Referral whereCode($value)
 * @method static Builder|Referral whereDateAdded($value)
 * @method static Builder|Referral whereId($value)
 * @method static Builder|Referral whereMonthlyFee($value)
 * @method static Builder|Referral whereSignUpFee($value)
 * @method static Builder|Referral whereUserId($value)
 * @mixin Eloquent
 */
class Referral extends Model
{
    use HasFactory, CreatedUpdatedBy;

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
        'code',
        'sign_up_fee',
        'monthly_fee',
        'account_level'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
