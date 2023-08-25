<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Email
 *
 * @package App\Models
 * @property string|null sent_status
 * @property int $id
 * @property string|null $email_type
 * @property int|null $unique_id
 * @property string|null $to
 * @property string|null $subject
 * @property string|null $body
 * @property string|null $filename
 * @property string|null $date_added
 * @property string|null $date_sent
 * @property string|null $notes
 * @method static Builder|Email newModelQuery()
 * @method static Builder|Email newQuery()
 * @method static Builder|Email query()
 * @method static Builder|Email whereBody($value)
 * @method static Builder|Email whereDateAdded($value)
 * @method static Builder|Email whereDateSent($value)
 * @method static Builder|Email whereEmailType($value)
 * @method static Builder|Email whereFilename($value)
 * @method static Builder|Email whereId($value)
 * @method static Builder|Email whereNotes($value)
 * @method static Builder|Email whereSent($value)
 * @method static Builder|Email whereSubject($value)
 * @method static Builder|Email whereTo($value)
 * @method static Builder|Email whereUniqueId($value)
 * @mixin Eloquent
 */
class Email extends Model
{
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_added';

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'email_type',
        'unique_id',
        'to',
        'subject',
        'body',
        'filename',
        'date_sent',
        'sent',
        'notes',
    ];
}
