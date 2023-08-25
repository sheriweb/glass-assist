<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Garages
 *
 * @package App\Models
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $address3
 * @property string|null $city
 * @property string|null $postcode
 * @property string|null $telno1
 * @property string|null $telno2
 * @property string|null $website
 * @property string|null $email
 * @property string|null $notes
 * @property int|null $status
 * @property int|null $exported
 * @property string|null $exported_file
 * @method static Builder|Garages newModelQuery()
 * @method static Builder|Garages newQuery()
 * @method static Builder|Garages query()
 * @method static Builder|Garages whereAddress1($value)
 * @method static Builder|Garages whereAddress2($value)
 * @method static Builder|Garages whereAddress3($value)
 * @method static Builder|Garages whereCity($value)
 * @method static Builder|Garages whereCode($value)
 * @method static Builder|Garages whereEmail($value)
 * @method static Builder|Garages whereExported($value)
 * @method static Builder|Garages whereExportedFile($value)
 * @method static Builder|Garages whereId($value)
 * @method static Builder|Garages whereName($value)
 * @method static Builder|Garages whereNotes($value)
 * @method static Builder|Garages wherePostcode($value)
 * @method static Builder|Garages whereStatus($value)
 * @method static Builder|Garages whereTelno1($value)
 * @method static Builder|Garages whereTelno2($value)
 * @method static Builder|Garages whereWebsite($value)
 * @mixin Eloquent
 */
class Garages extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'address1',
        'address2',
        'address3',
        'city',
        'postcode',
        'telno1',
        'telno2',
        'website',
        'email',
        'notes',
        'status',
        'exported',
        'exported_file'
    ];
}
