<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VehicleSale
 *
 * @package App\Models
 * @property string mileage
 * @property string part_ex_mileage
 * @property string invoice_number
 * @property string folio_number
 * @property string stock_book_number
 * @property integer price
 * @property integer admin_fee
 * @property integer extras
 * @property integer part_ex_cost
 * @property integer deposit
 * @property integer balance_to_pay
 * @property integer status
 * @property integer date_soled
 * @property integer added_by
 * @property-read Customer|null $customer
 * @property-read Staff|null $staff
 * @property-read Vehicle|null $vehicle
 * @method static Builder|VehicleSale newModelQuery()
 * @method static Builder|VehicleSale newQuery()
 * @method static Builder|VehicleSale query()
 * @mixin Eloquent
 */
class VehicleSale extends Model
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles_sales';

    /**
     * @var string[]
     */
    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'staff_id',
        'mileage',
        'part_ex_vehicle_id',
        'part_ex_mileage',
        'invoice_number',
        'folio_number',
        'stockbook_number',
        'price',
        'admin_fee',
        'extras',
        'part_ex_cost',
        'deposit',
        'balance_to_pay',
        'status',
        'date_soled'
    ];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('added_by')) {
                $model->added_by = auth()->user()->id;
            }

            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

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
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return BelongsTo
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}

