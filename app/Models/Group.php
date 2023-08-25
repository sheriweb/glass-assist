<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class BankHoliday
 *
 * @package App\Models
 * @property int $id
 * @property string|null $name
 * @property int $status
 * @property int $user_id
 * @property-read Collection|Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read User|null $user
 * @method static Builder|Group newModelQuery()
 * @method static Builder|Group newQuery()
 * @method static Builder|Group query()
 * @method static Builder|Group whereId($value)
 * @method static Builder|Group whereName($value)
 * @method static Builder|Group whereStatus($value)
 * @method static Builder|Group whereUserId($value)
 * @mixin Eloquent
 */
class Group extends Model
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
        'name',
        'status'
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'user'
    ];

    /**
     * @return BelongsToMany
     */
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customers_groups', 'group_id', 'customer_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
