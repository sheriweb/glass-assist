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
 * Class Vehicle
 *
 * @package App\Models
 * @property string|null due_date_one
 * @property string|null due_date_two
 * @property string|null due_date_three
 * @property string year_of_manufacture
 * @property string cylinder_capacity
 * @property string co_two_emissions
 * @property string fuel_type
 * @property string tax_status
 * @property string type_approval
 * @property string wheel_plan
 * @property string revenue_weight
 * @property string tax_details
 * @property string mot_details
 * @property string number_of_doors
 * @property string six_month_rate
 * @property float additional_price
 * @property int $id
 * @property int|null $make_id
 * @property int|null $model_id
 * @property string|null $name
 * @property string|null $reg_no
 * @property string|null $vin_number
 * @property string|null $commencement_date
 * @property string|null $yearOfManufacture
 * @property string|null $cylinderCapacity
 * @property string|null $co2Emissions
 * @property string|null $fuelType
 * @property string|null $taxStatus
 * @property string|null $colour
 * @property string|null $typeApproval
 * @property string|null $wheelPlan
 * @property string|null $revenueWeight
 * @property string|null $taxDetails
 * @property string|null $motDetails
 * @property string|null $taxed
 * @property string|null $mot
 * @property string|null $transmission
 * @property string|null $numberOfDoors
 * @property string|null $sixMonthRate
 * @property string|null $twelveMonthRate
 * @property string|null $notes
 * @property int $status
 * @property int|null $sale
 * @property int|null $sale_status
 * @property string|null $sale_price
 * @property string|null $date_of_purchase
 * @property string|null $date_of_sale
 * @property string|null $purchase_price
 * @property string|null $additional_cost
 * @property string|null $margin
 * @property string|null $margin_percent
 * @property int|null $sale_mileage
 * @property int $user_id
 * @property-read CarMake|null $carMake
 * @property-read CarModel|null $carModel
 * @property-read Collection|Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read User|null $user
 * @property-read Collection|VehicleDocument[] $vehicleDocument
 * @property-read int|null $vehicle_document_count
 * @property-read Collection|VehicleHistory[] $vehicleHistories
 * @property-read int|null $vehicle_histories_count
 * @property-read Collection|VehicleHistoryValues[] $vehicleHistoryValues
 * @property-read int|null $vehicle_history_values_count
 * @method static Builder|Vehicle newModelQuery()
 * @method static Builder|Vehicle newQuery()
 * @method static Builder|Vehicle query()
 * @method static Builder|Vehicle whereAdditionalCost($value)
 * @method static Builder|Vehicle whereCo2Emissions($value)
 * @method static Builder|Vehicle whereColour($value)
 * @method static Builder|Vehicle whereCommencementDate($value)
 * @method static Builder|Vehicle whereCylinderCapacity($value)
 * @method static Builder|Vehicle whereDateOfPurchase($value)
 * @method static Builder|Vehicle whereDateOfSale($value)
 * @method static Builder|Vehicle whereDueDate1($value)
 * @method static Builder|Vehicle whereDueDate2($value)
 * @method static Builder|Vehicle whereDueDate3($value)
 * @method static Builder|Vehicle whereFuelType($value)
 * @method static Builder|Vehicle whereId($value)
 * @method static Builder|Vehicle whereMakeId($value)
 * @method static Builder|Vehicle whereMargin($value)
 * @method static Builder|Vehicle whereMarginPercent($value)
 * @method static Builder|Vehicle whereModelId($value)
 * @method static Builder|Vehicle whereMot($value)
 * @method static Builder|Vehicle whereMotDetails($value)
 * @method static Builder|Vehicle whereName($value)
 * @method static Builder|Vehicle whereNotes($value)
 * @method static Builder|Vehicle whereNumberOfDoors($value)
 * @method static Builder|Vehicle wherePurchasePrice($value)
 * @method static Builder|Vehicle whereRegNo($value)
 * @method static Builder|Vehicle whereRevenueWeight($value)
 * @method static Builder|Vehicle whereSale($value)
 * @method static Builder|Vehicle whereSaleMileage($value)
 * @method static Builder|Vehicle whereSalePrice($value)
 * @method static Builder|Vehicle whereSaleStatus($value)
 * @method static Builder|Vehicle whereSixMonthRate($value)
 * @method static Builder|Vehicle whereStatus($value)
 * @method static Builder|Vehicle whereTaxDetails($value)
 * @method static Builder|Vehicle whereTaxStatus($value)
 * @method static Builder|Vehicle whereTaxed($value)
 * @method static Builder|Vehicle whereTransmission($value)
 * @method static Builder|Vehicle whereTwelveMonthRate($value)
 * @method static Builder|Vehicle whereTypeApproval($value)
 * @method static Builder|Vehicle whereUserId($value)
 * @method static Builder|Vehicle whereVinNumber($value)
 * @method static Builder|Vehicle whereWheelPlan($value)
 * @method static Builder|Vehicle whereYearOfManufacture($value)
 * @mixin Eloquent
 */
class Vehicle extends Model
{
    use HasFactory, CreatedUpdatedBy;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $with = [
        'user',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'make_id',
        'model_id',
        'reg_no',
        'vin_number',
        'due_date_1',
        'due_date_2',
        'due_date_3',
        'commencement_date',
        'yearOfManufacture',
        'cylinderCapacity',
        'co2Emissions',
        'fuelType',
        'taxStatus',
        'colour',
        'typeApproval',
        'wheelPlan',
        'revenueWeight',
        'taxDetails',
        'motDetails',
        'taxed',
        'mot',
        'transmission',
        'numberOfDoors',
        'sixMonthRate',
        'twelveMonthRate',
        'notes',
        'status',
        'sale',
        'sale_status',
        'sale_price',
        'date_of_purchase',
        'date_of_sale',
        'purchase_price',
        'additional_cost',
        'margin',
        'margin_percent',
        'sale_mileage'
    ];

    /**
     * @return BelongsToMany
     */
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customers_vehicles', 'vehicle_id', 'customer_id');
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

    /**
     * @return HasMany
     */
    public function vehicleHistories(): HasMany
    {
        return $this->hasMany(VehicleHistory::class);
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
    public function vehicleHistoryValues(): HasMany
    {
        return $this->hasMany(VehicleHistoryValues::class);
    }
}
