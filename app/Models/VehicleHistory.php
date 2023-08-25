<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use phpseclib3\Math\PrimeField\Integer;

/**
 * Class VehicleHistory
 *
 * @package App\Models
 * @property string|null payment_methods
 * @property string pre_check_note
 * @property string|null signature_one
 * @property integer|null job_completed
 * @property integer|null pre_job_completed
 * @property integer|null technician_one
 * @property integer|null technician_two
 * @property integer|null technician_three
 * @property string|null customer_requirement_one
 * @property string|null customer_requirement_two
 * @property string|null customer_requirement_three
 * @property string|null customer_requirement_four
 * @property string|null customer_requirement_five
 * @property string|null customer_requirement_six
 * @property string|null driving_licence_number
 * @property string|null driving_licence_expiry
 * @property string|null date_close
 * @property int $id
 * @property int $vehicle_id
 * @property int|null $customer_id
 * @property string|null $date_added
 * @property string|null $datetime
 * @property string|null $datetime_start
 * @property string|null $datetime_end
 * @property string|null $type
 * @property string|null $arrival_method
 * @property string|null $reference
 * @property string|null $item
 * @property string|null $miles
 * @property string|null $cost
 * @property string|null $amount_paid
 * @property string|null $details
 * @property string|null $glass_supplier
 * @property string|null $part_code
 * @property string|null $tech_details
 * @property string|null $pre_check_notes
 * @property string|null $batch_number
 * @property string|null $signature
 * @property string|null $c_name
 * @property string|null $pre_c_name
 * @property string|null $s_name
 * @property string|null $pre_s_name
 * @property string|null $s_date
 * @property string|null $pre_s_date
 * @property string|null $update_status_date
 * @property string|null $update_status_by
 * @property string|null $booked_by
 * @property int|null $courtesy_car
 * @property string|null $courtesy_car_start
 * @property string|null $courtesy_car_end
 * @property int $sms_sent
 * @property string|null $sms_sent_date
 * @property string|null $reason
 * @property string|null $invoice_notes
 * @property string|null $invoice_number
 * @property string|null $courtesy_car_mileage
 * @property string|null $courtesy_car_fuel
 * @property string|null $courtesy_car_commence
 * @property string|null $courtesy_car_return
 * @property string|null $time_allocated
 * @property string|null $completion_time
 * @property int|null $days_on_site
 * @property int $printed
 * @property int $status
 * @property string|null $date_onsite
 * @property string|null $date_closed
 * @property int|null $user_id
 * @property int|null $added_by
 * @property int|null $updated_by
 * @property string|null $date_updated
 * @property string|null $manual_make_model
 * @property string|null $mileage
 * @property string|null $job_cost
 * @property string|null $work_required
 * @property string|null $additional_details
 * @property string|null $calendar
 * @property string|null $sub_contractor
 * @property int|null $sc_confirm
 * @property string|null $sc_note
 * @property string|null $manual_mobile
 * @property string|null $manual_email
 * @property string|null $ref_caller_name
 * @property string|null $order_number
 * @property string|null $c_card_ref_number
 * @property string|null $ga_invoice_number
 * @property string|null $policy_number
 * @property string|null $expiry_date
 * @property string|null $warranty_work
 * @property string|null $cust_account
 * @property string|null $invoice_type
 * @property int|null $calibration
 * @property string|null $payment_type
 * @property string|null $technician_statement
 * @property string|null $technician_note
 * @property int|null $job_not_completed
 * @property string|null $not_completed_date
 * @property string|null $not_completed_by
 * @property-read CarMake|null $carMake
 * @property-read CarModel|null $carModel
 * @property-read Company|null $company
 * @property-read Customer|null $customer
 * @property-read GlassSupplier|null $glassSupplier
 * @property-read Group|null $groups
 * @property-read Item|null $items
 * @property-read Collection|JobCardItem[] $jobCardItems
 * @property-read int|null $job_card_items_count
 * @property-read SubContractor|null $subContractor
 * @property-read User|null $technicianData
 * @property-read Staff|null $technicianOne
 * @property-read Staff|null $technicianThree
 * @property-read Staff|null $technicianTwo
 * @property-read User|null $user
 * @property-read User|null $addedBy
 * @property-read User|null $updatedBy
 * @property-read Vehicle|null $vehicle
 * @property-read string|null $statusColor
 * @method static Builder|VehicleHistory newModelQuery()
 * @method static Builder|VehicleHistory newQuery()
 * @method static Builder|VehicleHistory query()
 * @method static Builder|VehicleHistory whereAddedBy($value)
 * @method static Builder|VehicleHistory whereAdditionalDetails($value)
 * @method static Builder|VehicleHistory whereAmountPaid($value)
 * @method static Builder|VehicleHistory whereArrivalMethod($value)
 * @method static Builder|VehicleHistory whereBatchNumber($value)
 * @method static Builder|VehicleHistory whereBookedBy($value)
 * @method static Builder|VehicleHistory whereCCardRefNumber($value)
 * @method static Builder|VehicleHistory whereCName($value)
 * @method static Builder|VehicleHistory whereCalendar($value)
 * @method static Builder|VehicleHistory whereCalibration($value)
 * @method static Builder|VehicleHistory whereCompanyName($value)
 * @method static Builder|VehicleHistory whereCompletionTime($value)
 * @method static Builder|VehicleHistory whereCost($value)
 * @method static Builder|VehicleHistory whereCourtesyCar($value)
 * @method static Builder|VehicleHistory whereCourtesyCarCommence($value)
 * @method static Builder|VehicleHistory whereCourtesyCarEnd($value)
 * @method static Builder|VehicleHistory whereCourtesyCarFuel($value)
 * @method static Builder|VehicleHistory whereCourtesyCarMileage($value)
 * @method static Builder|VehicleHistory whereCourtesyCarReturn($value)
 * @method static Builder|VehicleHistory whereCourtesyCarStart($value)
 * @method static Builder|VehicleHistory whereCustAccount($value)
 * @method static Builder|VehicleHistory whereCustomerId($value)
 * @method static Builder|VehicleHistory whereCustomerRequirement1($value)
 * @method static Builder|VehicleHistory whereCustomerRequirement2($value)
 * @method static Builder|VehicleHistory whereCustomerRequirement3($value)
 * @method static Builder|VehicleHistory whereCustomerRequirement4($value)
 * @method static Builder|VehicleHistory whereCustomerRequirement5($value)
 * @method static Builder|VehicleHistory whereCustomerRequirement6($value)
 * @method static Builder|VehicleHistory whereDateAdded($value)
 * @method static Builder|VehicleHistory whereDateClosed($value)
 * @method static Builder|VehicleHistory whereDateOnsite($value)
 * @method static Builder|VehicleHistory whereDateUpdated($value)
 * @method static Builder|VehicleHistory whereDatetime($value)
 * @method static Builder|VehicleHistory whereDatetimeEnd($value)
 * @method static Builder|VehicleHistory whereDatetimeStart($value)
 * @method static Builder|VehicleHistory whereDaysOnSite($value)
 * @method static Builder|VehicleHistory whereDetails($value)
 * @method static Builder|VehicleHistory whereDrivingLicenseExpiry($value)
 * @method static Builder|VehicleHistory whereDrivingLicenseNo($value)
 * @method static Builder|VehicleHistory whereExpiryDate($value)
 * @method static Builder|VehicleHistory whereGaInvoiceNumber($value)
 * @method static Builder|VehicleHistory whereGlassSupplier($value)
 * @method static Builder|VehicleHistory whereId($value)
 * @method static Builder|VehicleHistory whereInvoiceNotes($value)
 * @method static Builder|VehicleHistory whereInvoiceNumber($value)
 * @method static Builder|VehicleHistory whereInvoiceType($value)
 * @method static Builder|VehicleHistory whereItem($value)
 * @method static Builder|VehicleHistory whereJobComplete($value)
 * @method static Builder|VehicleHistory whereJobCost($value)
 * @method static Builder|VehicleHistory whereJobNotCompleted($value)
 * @method static Builder|VehicleHistory whereManualEmail($value)
 * @method static Builder|VehicleHistory whereManualMakeModel($value)
 * @method static Builder|VehicleHistory whereManualMobile($value)
 * @method static Builder|VehicleHistory whereMileage($value)
 * @method static Builder|VehicleHistory whereMiles($value)
 * @method static Builder|VehicleHistory whereNotCompletedBy($value)
 * @method static Builder|VehicleHistory whereNotCompletedDate($value)
 * @method static Builder|VehicleHistory whereOrderNumber($value)
 * @method static Builder|VehicleHistory wherePartCode($value)
 * @method static Builder|VehicleHistory wherePaymentMethod($value)
 * @method static Builder|VehicleHistory wherePaymentType($value)
 * @method static Builder|VehicleHistory wherePolicyNumber($value)
 * @method static Builder|VehicleHistory wherePreCName($value)
 * @method static Builder|VehicleHistory wherePreCheckNotes($value)
 * @method static Builder|VehicleHistory wherePreJobComplete($value)
 * @method static Builder|VehicleHistory wherePreSDate($value)
 * @method static Builder|VehicleHistory wherePreSName($value)
 * @method static Builder|VehicleHistory wherePrinted($value)
 * @method static Builder|VehicleHistory whereReason($value)
 * @method static Builder|VehicleHistory whereRefCallerName($value)
 * @method static Builder|VehicleHistory whereReference($value)
 * @method static Builder|VehicleHistory whereSDate($value)
 * @method static Builder|VehicleHistory whereSName($value)
 * @method static Builder|VehicleHistory whereScConfirm($value)
 * @method static Builder|VehicleHistory whereScNote($value)
 * @method static Builder|VehicleHistory whereSignature($value)
 * @method static Builder|VehicleHistory whereSignature1($value)
 * @method static Builder|VehicleHistory whereSmsSent($value)
 * @method static Builder|VehicleHistory whereSmsSentDate($value)
 * @method static Builder|VehicleHistory whereStatus($value)
 * @method static Builder|VehicleHistory whereSubContractor($value)
 * @method static Builder|VehicleHistory whereTechDetails($value)
 * @method static Builder|VehicleHistory whereTechnician1($value)
 * @method static Builder|VehicleHistory whereTechnician2($value)
 * @method static Builder|VehicleHistory whereTechnician3($value)
 * @method static Builder|VehicleHistory whereTechnicianNote($value)
 * @method static Builder|VehicleHistory whereTechnicianStatement($value)
 * @method static Builder|VehicleHistory whereTimeAllocated($value)
 * @method static Builder|VehicleHistory whereType($value)
 * @method static Builder|VehicleHistory whereUpdateStatusBy($value)
 * @method static Builder|VehicleHistory whereUpdateStatusDate($value)
 * @method static Builder|VehicleHistory whereUpdatedBy($value)
 * @method static Builder|VehicleHistory whereUserId($value)
 * @method static Builder|VehicleHistory whereVehicleId($value)
 * @method static Builder|VehicleHistory whereWarrantyWork($value)
 * @method static Builder|VehicleHistory whereWorkRequired($value)
 * @mixin Eloquent
 */
class VehicleHistory extends Model
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles_history';

    protected $appends = ['status_text','current_user', 'current_date_time'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'vehicle_id',
        'customer_id',
        'calendar',
        'company_name',
        // TODO: talha sa pochana ha
        //'reg_no',
        'mileage',
        'datetime',
        'datetime_start',
        'datetime_end',
        'type',
        'tech_details',
        'arrival_method',
        'reference',
        'item',
        'miles',
        'cost',
        'amount_paid',
        'payment_method',
        'details',
        'glass_supplier',
        'part_code',
        'tech_details',
        'pre_check_notes',
        'batch_number',
        'signature',
        'signature_1',
        'c_name',
        'pre_c_name',
        's_name',
        'pre_s_name',
        's_date',
        'pre_s_date',
        'update_status_date',
        'update_status_by',
        'job_complete',
        'pre_job_complete',
        'booked_by',
        'technician',
        'technician_1',
        'technician_2',
        'technician_3',
        'customer_requirement1',
        'customer_requirement2',
        'customer_requirement3',
        'customer_requirement4',
        'customer_requirement5',
        'customer_requirement6',
        'courtesy_car',
        'courtesy_car_start',
        'courtesy_car_end',
        'sms_sent',
        'sms_sent_date',
        'reason',
        'invoice_notes',
        'invoice_number',
        'driving_licence_no',
        'driving_licence_expiry',
        'courtesy_car_mileage',
        'courtesy_car_fuel',
        'courtesy_car_commence',
        'courtesy_car_return',
        'time_allocated',
        'completion_time',
        'days_on_site',
        'printed',
        'status',
        'date_onsite',
        'date_closed',
        'added_by',
        'updated_by',
        'manual_make_model',
        'mileage',
        'job_cost',
        'work_required',
        'additional_details',
        'sub_contractor',
        'sc_confirm',
        'sc_note',
        'manual_mobile',
        'manual_email',
        'ref_caller_name',
        'order_number',
        'c_card_ref_number',
        'ga_invoice_number',
        'policy_number',
        'expiry_date',
        'warranty_work',
        'cust_account',
        'invoice_type',
        'calibration',
        'payment_type',
        'technician_note',
        'job_not_completed',
        'not_completed_date',
        'not_completed_by',
        'technician_statement',
        'windscreen_lookup_id',
        'vehicle_reg',
        'vin_number',
        'vehicle_year_manufacture',
        'vehicle_make',
        'vehicle_model',
        'glass_position',
        'argic_no',
    ];

    /**
     * @return BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * @return BelongsTo
     */
    public function glassSupplier(): BelongsTo
    {
        return $this->belongsTo(GlassSupplier::class, 'glass_supplier', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function subContractor(): BelongsTo
    {
        return $this->belongsTo(SubContractor::class, 'sub_contractor', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function items(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function technicianData(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician');
    }

    /**
     * @return BelongsTo
     */
    public function technicianOne(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'technician_1', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function technicianTwo(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'technician_2', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function technicianThree(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'technician_3', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_name', 'id');
    }

    /**
     * @return HasMany
     */
    public function jobCardItems(): HasMany
    {
        return $this->hasMany(JobCardItem::class, 'history_id');
    }

    /**
     * @return HasMany
     */
    public function jobCardDetails(): HasMany
    {
        return $this->hasMany(JobCardItem::class, 'history_id');
    }

    /**
     * @return BelongsTo
     */
    public function courtesyCar(): BelongsTo
    {
        return $this->belongsTo(CourtesyCar::class);
    }

    /**
     * @return BelongsTo
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusTextAttribute(): string
    {
        return $this->statusText($this->attributes['status']);
    }

    public function getCurrentUserAttribute(): string
    {
        return auth()->user()->first_name;
    }
    public function getCurrentDateTimeAttribute(): string
    {
        return Carbon::now();
    }
    /**
     * @return string
     */
    public function statusColor(): string
    {
        $color = "#000";

        switch ($this->status) {
            case 1:
                $color = "#f32f53";
                break;
            case 2:
                $color = "darkorange";
                break;
            case 3:
                $color = "lightgreen";
                break;
            case 4:
                $color = "purple";
                break;
            case 5:
                $color = "#6d5d6e";
                break;
            case 6:
                $color = "#007BFF";
                break;
            case 7:
                $color = "#ffcc44";
                break;
            case 8:
                $color = "#dddddd";
                break;
            case 9:
                $color = "magenta";
                break;
            default:
                $color = "#0f9cf3";
        }

        return $color;
    }

    /**
     * @return string
     */
    public function statusText(): string
    {
        switch ($this->status) {
            case 1:
                $text = "Pending";
                break;
            case 2:
                $text = "In Progress";
                break;
            case 3:
                $text = "Job Completed";
                break;
            case 4:
                $text = "Awaiting Auth";
                break;
            case 5:
                $text = "Awaiting Parts";
                break;
            case 6:
                $text = "Priority";
                break;
            case 7:
                $text = "Invoiced";
                break;
            case 8:
                $text = "Cancelled";
                break;
            case 9:
                $text = "Quote";
                break;
        }

        return $text;
    }

    /**
     * @param $status
     * @return int
     */
    public static function statusId($status): Int
    {
        switch ($status) {
            case 'pending':
                $id = 1;
                break;
            case 'in_progress':
                $id = 2;
                break;
            case 'job_completed':
                $id = 3;
                break;
            case 'awaiting_auth':
                $id = 4;
                break;
            case 'awaiting_parts':
                $id = 5;
                break;
            case 'priority':
                $id = 6;
                break;
            case 'invoiced':
                $id = 7;
                break;
            case 'cancelled':
                $id = 8;
                break;
            case 'quote':
                $id = 9;
                break;
        }

        return $id;
    }
}
