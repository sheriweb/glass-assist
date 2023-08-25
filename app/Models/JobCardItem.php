<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class JobCardItem
 *
 * @package App\Models
 * @property string type
 * @property integer quantity
 * @property integer cost_price
 * @property integer sale_price
 * @property string description
 * @property string date_added
 * @property integer status
 * @property-read User|null $user
 * @property-read JobCardItem|null $vehicleHistory
 * @method static Builder|JobCardItem newModelQuery()
 * @method static Builder|JobCardItem newQuery()
 * @method static Builder|JobCardItem query()
 * @mixin Eloquent
 */
class JobCardItem extends Model
{
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_added';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobcard_items';

    /**
     * @var string[]
     */
    protected $fillable = [
        'history_id',
        'type',
        'qty',
        'cost_price',
        'sell_price',
        'description',
        'status'
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
    public function vehicleHistory(): BelongsTo
    {
        return $this->belongsTo(JobCardItem::class, 'history_id', 'id');
    }
}
