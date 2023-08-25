<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Order
 *
 * @package App\Models
 * @property integer amount
 * @property string raw_name
 * @property string sub_scr_date
 * @property integer mc_amount_three
 * @property string period_three
 * @property string tax_number_type
 * @property int $id
 * @property int|null $user_id
 * @property string|null $gocardless_user_id
 * @property string|null $gocardless_bill_id
 * @property int $qty
 * @property string $amt
 * @property string|null $type
 * @property string $date_added
 * @property string $date_updated
 * @property int $status
 * @property string|null $raw_data
 * @property string|null $address_name
 * @property string|null $address_street
 * @property string|null $address_city
 * @property string|null $address_state
 * @property string|null $address_zip
 * @property string|null $address_country
 * @property string|null $address_country_code
 * @property string|null $address_status
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $item_name
 * @property int|null $item_number
 * @property int|null $quantity
 * @property string|null $payment_date
 * @property string|null $payment_fee
 * @property string|null $payment_gross
 * @property string|null $payment_status
 * @property string|null $payment_type
 * @property string|null $subscr_date
 * @property string|null $subscr_id
 * @property string|null $mc_currency
 * @property string|null $mc_fee
 * @property string|null $mc_gross
 * @property string|null $shipping
 * @property string|null $tax
 * @property string|null $handling_amount
 * @property string|null $mc_amount3
 * @property string|null $period3
 * @property int|null $reattempt
 * @property int|null $recurring
 * @property string|null $payer_email
 * @property string|null $payer_id
 * @property string|null $payer_status
 * @property string|null $txn_id
 * @property string|null $txn_type
 * @property int|null $custom
 * @property-read User|null $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddressCity($value)
 * @method static Builder|Order whereAddressCountry($value)
 * @method static Builder|Order whereAddressCountryCode($value)
 * @method static Builder|Order whereAddressName($value)
 * @method static Builder|Order whereAddressState($value)
 * @method static Builder|Order whereAddressStatus($value)
 * @method static Builder|Order whereAddressStreet($value)
 * @method static Builder|Order whereAddressZip($value)
 * @method static Builder|Order whereAmt($value)
 * @method static Builder|Order whereCustom($value)
 * @method static Builder|Order whereDateAdded($value)
 * @method static Builder|Order whereDateUpdated($value)
 * @method static Builder|Order whereFirstName($value)
 * @method static Builder|Order whereGocardlessBillId($value)
 * @method static Builder|Order whereGocardlessUserId($value)
 * @method static Builder|Order whereHandlingAmount($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereItemName($value)
 * @method static Builder|Order whereItemNumber($value)
 * @method static Builder|Order whereLastName($value)
 * @method static Builder|Order whereMcAmount3($value)
 * @method static Builder|Order whereMcCurrency($value)
 * @method static Builder|Order whereMcFee($value)
 * @method static Builder|Order whereMcGross($value)
 * @method static Builder|Order wherePayerEmail($value)
 * @method static Builder|Order wherePayerId($value)
 * @method static Builder|Order wherePayerStatus($value)
 * @method static Builder|Order wherePaymentDate($value)
 * @method static Builder|Order wherePaymentFee($value)
 * @method static Builder|Order wherePaymentGross($value)
 * @method static Builder|Order wherePaymentStatus($value)
 * @method static Builder|Order wherePaymentType($value)
 * @method static Builder|Order wherePeriod3($value)
 * @method static Builder|Order whereQty($value)
 * @method static Builder|Order whereQuantity($value)
 * @method static Builder|Order whereRawData($value)
 * @method static Builder|Order whereReattempt($value)
 * @method static Builder|Order whereRecurring($value)
 * @method static Builder|Order whereShipping($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereSubscrDate($value)
 * @method static Builder|Order whereSubscrId($value)
 * @method static Builder|Order whereTax($value)
 * @method static Builder|Order whereTxnId($value)
 * @method static Builder|Order whereTxnType($value)
 * @method static Builder|Order whereType($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
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
        'first_name',
        'last_name',
        'gocardless_user_id',
        'gocardless_bill_id',
        'item_name',
        'item_number',
        'quantity',
        'qty',
        'amt',
        'type',
        'status',
        'raw_data',
        'address_name',
        'address_city',
        'address_state',
        'address_street',
        'address_zip',
        'address_country',
        'address_country_code',
        'address_status',
        'quantity',
        'payment_date',
        'payment_fee',
        'payment_gross',
        'payment_status',
        'payment_type',
        'subscr_date',
        'subscr_id',
        'mc_currency',
        'mc_fee',
        'mc_gross',
        'shipping',
        'tax',
        'handling_amount',
        'mc_amount3',
        'period3',
        'reattempt',
        'recurring',
        'payer_email',
        'payer_id',
        'payer_status',
        'txn_id',
        'txn_type',
        'custom',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
