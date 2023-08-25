<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CourtesyCar
 *
 * @package App\Models
 * @property string registration_number
 * @property int $id
 * @property int|null $user_id
 * @property string|null $date_added
 * @property string|null $date_updated
 * @property string|null $name
 * @property string|null $colour
 * @property int|null $make_id
 * @property int|null $model_id
 * @property string|null $reg_no
 * @property int $status
 * @property-read CarMake|null $carMake
 * @property-read CarModel|null $carModel
 * @property-read User|null $user
 * @method static Builder|CourtesyCar newModelQuery()
 * @method static Builder|CourtesyCar newQuery()
 * @method static Builder|CourtesyCar query()
 * @method static Builder|CourtesyCar whereColour($value)
 * @method static Builder|CourtesyCar whereDateAdded($value)
 * @method static Builder|CourtesyCar whereDateUpdated($value)
 * @method static Builder|CourtesyCar whereId($value)
 * @method static Builder|CourtesyCar whereMakeId($value)
 * @method static Builder|CourtesyCar whereModelId($value)
 * @method static Builder|CourtesyCar whereName($value)
 * @method static Builder|CourtesyCar whereRegNo($value)
 * @method static Builder|CourtesyCar whereStatus($value)
 * @method static Builder|CourtesyCar whereUserId($value)
 * @mixin Eloquent
 */
class CourtesyCar extends Model
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
    const UPDATED_AT = 'date_updated';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'colour',
        'make_id',
        'model_id',
        'reg_no',
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
    public function carMake(): BelongsTo
    {
        return $this->belongsTo(CarMake::class, 'make_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'model_id', 'id');
    }
}
