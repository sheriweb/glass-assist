<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GroupMailRecipient
 *
 * @package App\Models
 * @property int $id
 * @property int|null $group_mail_id
 * @property string|null $email
 * @property int $is_sent
 * @property string|null $date_sent
 * @property-read GroupMail|null $groupMail
 * @method static Builder|GroupMailRecipient newModelQuery()
 * @method static Builder|GroupMailRecipient newQuery()
 * @method static Builder|GroupMailRecipient query()
 * @method static Builder|GroupMailRecipient whereDateSent($value)
 * @method static Builder|GroupMailRecipient whereEmail($value)
 * @method static Builder|GroupMailRecipient whereGroupMailId($value)
 * @method static Builder|GroupMailRecipient whereId($value)
 * @method static Builder|GroupMailRecipient whereIsSent($value)
 * @mixin Eloquent
 */
class GroupMailRecipient extends Model
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
        'email',
        'is_sent',
        'date_sent',
        'group_mail_id'
    ];

    /**
     * @return BelongsTo
     */
    public function groupMail(): BelongsTo
    {
        return $this->belongsTo(GroupMail::class);
    }
}
