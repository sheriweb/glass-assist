<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Supplier
 *
 * @package App\Models
 * @property integer vat
 * @property int $id
 * @property string|null $name
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $postcode
 * @property string|null $email
 * @property string|null $phone
 * @property int|null $status
 * @property int|null $user_id
 * @property string|null $date_added
 * @property string|null $date_updated
 * @property string|null $date_deleted
 * @property-read User|null $user
 * @method static Builder|Supplier newModelQuery()
 * @method static Builder|Supplier newQuery()
 * @method static Builder|Supplier query()
 * @method static Builder|Supplier whereAddress1($value)
 * @method static Builder|Supplier whereAddress2($value)
 * @method static Builder|Supplier whereCity($value)
 * @method static Builder|Supplier whereCounty($value)
 * @method static Builder|Supplier whereDateAdded($value)
 * @method static Builder|Supplier whereDateDeleted($value)
 * @method static Builder|Supplier whereDateUpdated($value)
 * @method static Builder|Supplier whereEmail($value)
 * @method static Builder|Supplier whereId($value)
 * @method static Builder|Supplier whereName($value)
 * @method static Builder|Supplier wherePhone($value)
 * @method static Builder|Supplier wherePostcode($value)
 * @method static Builder|Supplier whereStatus($value)
 * @method static Builder|Supplier whereUserId($value)
 * @mixin Eloquent
 */
class Supplier extends Model
{
    use HasFactory, CreatedUpdatedBy;

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
        'name',
        'email',
        'address_1',
        'address_2',
        'city',
        'county',
        'postcode',
        'phone',
        'phone_2',
        'status',
        'date_deleted'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
