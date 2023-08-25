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
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Customer
 *
 * @package App\Models
 * @property int $id
 * @property string|null $company_name
 * @property string|null $title
 * @property string|null $first_name
 * @property string|null $surname
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $postcode
 * @property string|null $country
 * @property string|null $county
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $fax
 * @property string|null $email
 * @property string|null $dob
 * @property int $send_text
 * @property int $send_email
 * @property string $date_created
 * @property string|null $date_updated
 * @property string|null $notes
 * @property string|null $link
 * @property int $viewer_access
 * @property int $status
 * @property int $user_id
 * @property string|null $lng
 * @property string|null $lat
 * @property int $correct_postal_code
 * @property-read Company|null $company
 * @property-read Collection|Group[] $groups
 * @property-read int|null $groups_count
 * @property-read User|null $user
 * @property-read Collection|Customer[] $vehicleHistories
 * @property-read int|null $vehicle_histories_count
 * @property-read Collection|VehicleSale[] $vehicleSales
 * @property-read int|null $vehicle_sales_count
 * @property-read Collection|Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereAddress1($value)
 * @method static Builder|Customer whereAddress2($value)
 * @method static Builder|Customer whereCity($value)
 * @method static Builder|Customer whereCompanyName($value)
 * @method static Builder|Customer whereCorrectPostalCode($value)
 * @method static Builder|Customer whereCountry($value)
 * @method static Builder|Customer whereCounty($value)
 * @method static Builder|Customer whereDateCreated($value)
 * @method static Builder|Customer whereDateUpdated($value)
 * @method static Builder|Customer whereDob($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereFax($value)
 * @method static Builder|Customer whereFirstName($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereLat($value)
 * @method static Builder|Customer whereLink($value)
 * @method static Builder|Customer whereLng($value)
 * @method static Builder|Customer whereMobile($value)
 * @method static Builder|Customer whereNotes($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static Builder|Customer wherePostcode($value)
 * @method static Builder|Customer whereSendEmail($value)
 * @method static Builder|Customer whereSendText($value)
 * @method static Builder|Customer whereStatus($value)
 * @method static Builder|Customer whereSurname($value)
 * @method static Builder|Customer whereTitle($value)
 * @method static Builder|Customer whereUserId($value)
 * @method static Builder|Customer whereViewerAccess($value)
 * @mixin Eloquent
 */
class Customer extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_created';

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
        'company_name',
        'first_name',
        'surname',
        'dob',
        'email',
        'phone',
        'fax',
        'mobile',
        'date_of_birth',
        'title',
        'address_1',
        'address_2',
        'postcode',
        'city',
        'country',
        'county',
        'send_text',
        'send_email',
        'notes',
        'link',
        'lng',
        'lat',
        'viewer_access',
        'status',
        'correct_postal_code'
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
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_name', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'customers_groups', 'customer_id', 'group_id');
    }

    /**
     * @return BelongsToMany
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'customers_vehicles', 'customer_id', 'vehicle_id');
    }

    /**
     * @return HasMany
     */
    public function vehicleHistories(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * @return HasMany
     */
    public function vehicleSales(): HasMany
    {
        return $this->hasMany(VehicleSale::class);
    }

    /**
     * @return BelongsTo
     */
    public function sent(): BelongsTo
    {
        return $this->belongsTo(Sent::class);
    }
}
