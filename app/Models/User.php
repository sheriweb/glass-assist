<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @package App\Models
 * @property int $id
 * @property int $account_user_id
 * @property int $account_level
 * @property int $access_level
 * @property string|null $gocardless_user_id
 * @property string|null $email
 * @property string|null $username
 * @property string|null $password
 * @property string|null $password_salt
 * @property string|null $company_name
 * @property int|null $vat_registered
 * @property string|null $vat_number
 * @property string|null $referral_code
 * @property int|null $status
 * @property string|null $title
 * @property string|null $first_name
 * @property string|null $surname
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $city
 * @property string|null $county
 * @property string|null $postcode
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $logo
 * @property string|null $twitter_url
 * @property string|null $facebook_url
 * @property string|null $linkedin_url
 * @property string|null $youtube_url
 * @property string|null $website_url
 * @property string|null $website2_url
 * @property string|null $link_01
 * @property string|null $link_02
 * @property string|null $link_03
 * @property string|null $link_04
 * @property string|null $link_05
 * @property string|null $link_06
 * @property string|null $link_07
 * @property string|null $link_08
 * @property string|null $link_09
 * @property string|null $link_10
 * @property string|null $link_11
 * @property string|null $link_12
 * @property string|null $link_01_colour
 * @property string|null $link_02_colour
 * @property string|null $link_03_colour
 * @property string|null $link_04_colour
 * @property string|null $link_05_colour
 * @property string|null $link_06_colour
 * @property string|null $link_07_colour
 * @property string|null $link_08_colour
 * @property string|null $link_09_colour
 * @property string|null $link_10_colour
 * @property string|null $link_11_colour
 * @property string|null $link_12_colour
 * @property string|null $link_01_code
 * @property string|null $link_02_code
 * @property string|null $link_03_code
 * @property string|null $link_04_code
 * @property string|null $link_05_code
 * @property string|null $link_06_code
 * @property string|null $link_07_code
 * @property string|null $link_08_code
 * @property string|null $link_09_code
 * @property string|null $link_10_code
 * @property string|null $link_11_code
 * @property string|null $link_12_code
 * @property string|null $colour_1 Site Background
 * @property string|null $colour_2 Site Text
 * @property string|null $colour_3 Site Links
 * @property string|null $colour_4 Header Background
 * @property string|null $colour_5 Header Text
 * @property string|null $colour_6 Table Background
 * @property string|null $colour_7 Borders
 * @property string|null $colour_8 Table Headers
 * @property string|null $tag_customer
 * @property string|null $tag_vehicle
 * @property string|null $tag_item
 * @property string|null $tag_vehicle_reg
 * @property string|null $tag_vin_number
 * @property string|null $tag_miles
 * @property string|null $tag_due_date_1
 * @property string|null $tag_due_date_2
 * @property string|null $tag_due_date_3
 * @property string|null $tag_reminder
 * @property string|null $msg_due_date_1
 * @property string|null $msg_due_date_2
 * @property string|null $msg_due_date_3
 * @property string|null $msg_booking_24
 * @property string|null $msg_booking_24_pickup
 * @property string|null $msg_booking_24_cc
 * @property string|null $msg_booking_instant
 * @property string|null $msg_booking_completed
 * @property int|null $show_payment_method
 * @property int|null $show_cost
 * @property int|null $show_amount_paid
 * @property int|null $show_company
 * @property int|null $show_invoice_margin
 * @property int|null $enable_cron
 * @property int|null $invoice_margin_top
 * @property int|null $invoice_margin_bottom
 * @property string|null $hourly_rate
 * @property string|null $start_time
 * @property string|null $default_due_date
 * @property string|null $date_added
 * @property int|null $added_by
 * @property string|null $date_updated
 * @property int|null $updated_by
 * @property string|null $last_login
 * @property string|null $subscription_starts
 * @property string|null $subscription_expires
 * @property string|null $archived_date
 * @property-read Collection|BankHoliday[] $bankholidays
 * @property-read int|null $bankholidays_count
 * @property-read Collection|CarMake[] $carMakes
 * @property-read int|null $car_makes_count
 * @property-read Collection|CarModel[] $carModels
 * @property-read int|null $car_models_count
 * @property-read Collection|Company[] $companies
 * @property-read int|null $companies_count
 * @property-read Collection|CourtesyCar[] $courtesyCars
 * @property-read int|null $courtesy_cars_count
 * @property-read Collection|Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read Collection|DvlaLookup[] $dvlaLookups
 * @property-read int|null $dvla_lookups_count
 * @property-read Collection|GlassSupplier[] $glassSuppliers
 * @property-read int|null $glass_suppliers_count
 * @property-read Collection|Group[] $groups
 * @property-read int|null $groups_count
 * @property-read Collection|Holiday[] $holidays
 * @property-read int|null $holidays_count
 * @property-read Collection|Item[] $items
 * @property-read int|null $items_count
 * @property-read Collection|JobCardItem[] $jobCardItems
 * @property-read int|null $job_card_items_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|User[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Referral[] $referral
 * @property-read int|null $referral_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|Staff[] $staff
 * @property-read int|null $staff_count
 * @property-read Collection|SubContractor[] $subContractors
 * @property-read int|null $sub_contractors_count
 * @property-read Collection|Supplier[] $suppliers
 * @property-read int|null $suppliers_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read Collection|VehicleDocument[] $vehicleDocument
 * @property-read int|null $vehicle_document_count
 * @property-read Collection|VehicleHistory[] $vehicleHistories
 * @property-read Collection|VehicleHistory[] $vehicleHistoriesForDate
 * @property-read int|null $vehicle_histories_count
 * @property-read Collection|VehicleMaintenance[] $vehicleMaintenances
 * @property-read int|null $vehicle_maintenances_count
 * @property-read Collection|VehicleSale[] $vehicleSale
 * @property-read int|null $vehicle_sale_count
 * @property-read Collection|Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereAccessLevel($value)
 * @method static Builder|User whereAccountLevel($value)
 * @method static Builder|User whereAccountUserId($value)
 * @method static Builder|User whereAddedBy($value)
 * @method static Builder|User whereAddress1($value)
 * @method static Builder|User whereAddress2($value)
 * @method static Builder|User whereArchivedDate($value)
 * @method static Builder|User whereCity($value)
 * @method static Builder|User whereColour1($value)
 * @method static Builder|User whereColour2($value)
 * @method static Builder|User whereColour3($value)
 * @method static Builder|User whereColour4($value)
 * @method static Builder|User whereColour5($value)
 * @method static Builder|User whereColour6($value)
 * @method static Builder|User whereColour7($value)
 * @method static Builder|User whereColour8($value)
 * @method static Builder|User whereCompanyName($value)
 * @method static Builder|User whereCounty($value)
 * @method static Builder|User whereDateAdded($value)
 * @method static Builder|User whereDateUpdated($value)
 * @method static Builder|User whereDefaultDueDate($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEnableCron($value)
 * @method static Builder|User whereFacebookUrl($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereGocardlessUserId($value)
 * @method static Builder|User whereHourlyRate($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereInvoiceMarginBottom($value)
 * @method static Builder|User whereInvoiceMarginTop($value)
 * @method static Builder|User whereLastLogin($value)
 * @method static Builder|User whereLink01($value)
 * @method static Builder|User whereLink01Code($value)
 * @method static Builder|User whereLink01Colour($value)
 * @method static Builder|User whereLink02($value)
 * @method static Builder|User whereLink02Code($value)
 * @method static Builder|User whereLink02Colour($value)
 * @method static Builder|User whereLink03($value)
 * @method static Builder|User whereLink03Code($value)
 * @method static Builder|User whereLink03Colour($value)
 * @method static Builder|User whereLink04($value)
 * @method static Builder|User whereLink04Code($value)
 * @method static Builder|User whereLink04Colour($value)
 * @method static Builder|User whereLink05($value)
 * @method static Builder|User whereLink05Code($value)
 * @method static Builder|User whereLink05Colour($value)
 * @method static Builder|User whereLink06($value)
 * @method static Builder|User whereLink06Code($value)
 * @method static Builder|User whereLink06Colour($value)
 * @method static Builder|User whereLink07($value)
 * @method static Builder|User whereLink07Code($value)
 * @method static Builder|User whereLink07Colour($value)
 * @method static Builder|User whereLink08($value)
 * @method static Builder|User whereLink08Code($value)
 * @method static Builder|User whereLink08Colour($value)
 * @method static Builder|User whereLink09($value)
 * @method static Builder|User whereLink09Code($value)
 * @method static Builder|User whereLink09Colour($value)
 * @method static Builder|User whereLink10($value)
 * @method static Builder|User whereLink10Code($value)
 * @method static Builder|User whereLink10Colour($value)
 * @method static Builder|User whereLink11($value)
 * @method static Builder|User whereLink11Code($value)
 * @method static Builder|User whereLink11Colour($value)
 * @method static Builder|User whereLink12($value)
 * @method static Builder|User whereLink12Code($value)
 * @method static Builder|User whereLink12Colour($value)
 * @method static Builder|User whereLinkedinUrl($value)
 * @method static Builder|User whereLogo($value)
 * @method static Builder|User whereMobile($value)
 * @method static Builder|User whereMsgBooking24($value)
 * @method static Builder|User whereMsgBooking24Cc($value)
 * @method static Builder|User whereMsgBooking24Pickup($value)
 * @method static Builder|User whereMsgBookingCompleted($value)
 * @method static Builder|User whereMsgBookingInstant($value)
 * @method static Builder|User whereMsgDueDate1($value)
 * @method static Builder|User whereMsgDueDate2($value)
 * @method static Builder|User whereMsgDueDate3($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePasswordSalt($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePostcode($value)
 * @method static Builder|User whereReferralCode($value)
 * @method static Builder|User whereShowAmountPaid($value)
 * @method static Builder|User whereShowCompany($value)
 * @method static Builder|User whereShowCost($value)
 * @method static Builder|User whereShowInvoiceMargin($value)
 * @method static Builder|User whereShowPaymentMethod($value)
 * @method static Builder|User whereStartTime($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereSubscriptionExpires($value)
 * @method static Builder|User whereSubscriptionStarts($value)
 * @method static Builder|User whereSurname($value)
 * @method static Builder|User whereTagCustomer($value)
 * @method static Builder|User whereTagDueDate1($value)
 * @method static Builder|User whereTagDueDate2($value)
 * @method static Builder|User whereTagDueDate3($value)
 * @method static Builder|User whereTagItem($value)
 * @method static Builder|User whereTagMiles($value)
 * @method static Builder|User whereTagReminder($value)
 * @method static Builder|User whereTagVehicle($value)
 * @method static Builder|User whereTagVehicleReg($value)
 * @method static Builder|User whereTagVinNumber($value)
 * @method static Builder|User whereTitle($value)
 * @method static Builder|User whereTwitterUrl($value)
 * @method static Builder|User whereUpdatedBy($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User whereVatNumber($value)
 * @method static Builder|User whereVatRegistered($value)
 * @method static Builder|User whereWebsite2Url($value)
 * @method static Builder|User whereWebsiteUrl($value)
 * @method static Builder|User whereYoutubeUrl($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_user_id',
        'access_level',
        'gocardless_user_id',
        'company_name',
        'referral_code',
        'link_01',
        'link_01_colour',
        'twitter_url',
        'facebook_url',
        'linkedin_url',
        'youtube_url',
        'website_url',
        'website2_url',
        'vat_registered',
        'link_01_code',
        'vat_number',
        'link_02',
        'link_02_colour',
        'link_02_code',
        'link_03',
        'link_03_colour',
        'link_03_code',
        'link_04',
        'link_04_colour',
        'link_04_code',
        'link_05',
        'link_05_colour',
        'link_05_code',
        'link_06',
        'link_06_colour',
        'link_06_code',
        'link_07',
        'link_07_colour',
        'link_07_code',
        'link_08',
        'link_08_colour',
        'link_08_code',
        'link_09',
        'link_09_colour',
        'link_09_code',
        'link_10',
        'link_10_colour',
        'link_10_code',
        'link_11',
        'link_11_colour',
        'link_11_code',
        'link_12',
        'link_12_colour',
        'link_12_code',
        'address_1',
        'address_2',
        'city',
        'county',
        'postcode',
        'first_name',
        'phone',
        'mobile',
        'title',
        'surname',
        'username',
        'email',
        'account_level',
        'password_salt',
        'password',
        'colour_1',
        'colour_2',
        'colour_3',
        'colour_4',
        'colour_5',
        'colour_6',
        'colour_7',
        'colour_8',
        'enable_cron',
        'tag_customer',
        'show_payment_method',
        'tag_vehicle',
        'show_cost',
        'tag_item',
        'show_amount_paid',
        'tag_vehicle_reg',
        'show_company',
        'tag_vin_number',
        'show_invoice_margin',
        'tag_miles',
        'invoice_margin_top',
        'tag_due_date_1',
        'tag_due_date_2',
        'tag_due_date_3',
        'invoice_margin_bottom',
        'hourly_rate',
        'start_time',
        'tag_reminder',
        'default_due_date',
        'msg_due_date_1',
        'msg_booking_24',
        'msg_due_date_2',
        'msg_booking_24_pickup',
        'msg_due_date_3',
        'msg_booking_24_cc',
        'msg_booking_instant',
        'msg_booking_completed',
        'logo',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'password_salt'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function subContractors(): HasMany
    {
        return $this->hasMany(SubContractor::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function bankHolidays(): HasMany
    {
        return $this->hasMany(BankHoliday::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function carMakes(): HasMany
    {
        return $this->hasMany(CarMake::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function courtesyCars(): HasMany
    {
        return $this->hasMany(CourtesyCar::class);
    }

    /**
     * @return HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * @return HasMany
     */
    public function dvlaLookups(): HasMany
    {
        return $this->hasMany(DvlaLookup::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function glassSuppliers(): HasMany
    {
        return $this->hasMany(GlassSupplier::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    /**
     * @return HasMany
     */
    public function holidays(): HasMany
    {
        return $this->hasMany(Holiday::class);
    }

    /**
     * @return HasMany
     */
    public function vehicleHistories(): HasMany
    {
        return $this->hasMany(VehicleHistory::class, 'technician', 'id');
    }

    /**
     * @return HasMany
     */
    public function jobCardItems(): HasMany
    {
        return $this->hasMany(JobCardItem::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function vehicleMaintenances(): HasOne
    {
        return $this->hasOne(VehicleMaintenance::class, 'linked_user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function vehicleDocument(): HasMany
    {
        return $this->hasMany(VehicleDocument::class);
    }

    /**
     * @return HasMany
     */
    public function vehicleSale(): HasMany
    {
        return $this->hasMany(VehicleSale::class);
    }

    /**
     * @return HasMany
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'user_id', 'id');
    }

    /**
     * @param string $date
     * @return HasMany
     */
    public function vehicleHistoriesForDate(string $date): HasMany
    {
        $startOfDay = Carbon::parse($date)->startOfDay();
        $endOfDay = Carbon::parse($date)->endOfDay();

        return $this->hasMany(VehicleHistory::class, 'technician', 'id')
            ->whereBetween('datetime', [$startOfDay, $endOfDay]);
    }
}
