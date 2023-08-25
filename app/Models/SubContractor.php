<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SubContractor
 *
 * @package App\Models
 * @property int $id
 * @property string|null $name
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $postcode
 * @property string|null $email1
 * @property string|null $email2
 * @property string|null $email3
 * @property string|null $phone
 * @property int|null $status
 * @property int|null $user_id
 * @property string|null $date_added
 * @property string|null $date_updated
 * @property string|null $date_deleted
 * @property-read User|null $user
 * @method static Builder|SubContractor newModelQuery()
 * @method static Builder|SubContractor newQuery()
 * @method static Builder|SubContractor query()
 * @method static Builder|SubContractor whereAddress1($value)
 * @method static Builder|SubContractor whereAddress2($value)
 * @method static Builder|SubContractor whereCity($value)
 * @method static Builder|SubContractor whereCounty($value)
 * @method static Builder|SubContractor whereDateAdded($value)
 * @method static Builder|SubContractor whereDateDeleted($value)
 * @method static Builder|SubContractor whereDateUpdated($value)
 * @method static Builder|SubContractor whereEmail1($value)
 * @method static Builder|SubContractor whereEmail2($value)
 * @method static Builder|SubContractor whereEmail3($value)
 * @method static Builder|SubContractor whereId($value)
 * @method static Builder|SubContractor whereName($value)
 * @method static Builder|SubContractor wherePhone($value)
 * @method static Builder|SubContractor wherePostcode($value)
 * @method static Builder|SubContractor whereStatus($value)
 * @method static Builder|SubContractor whereUserId($value)
 * @mixin Eloquent
 */
class SubContractor extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subcontractors';

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
        'email1',
        'email2',
        'email3',
        'address_1',
        'address_2',
        'city',
        'postcode',
        'county',
        'office_phone',
        'phone',
        'phone_2',
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
