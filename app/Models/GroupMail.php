<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class GroupMail
 *
 * @package App\Models
 * @property int $id
 * @property string $type
 * @property string $date
 * @property string $subject
 * @property string $body
 * @property int|null $is_confirm
 * @property-read Collection|GroupMailAttachment[] $groupMailAttachments
 * @property-read int|null $group_mail_attachments_count
 * @property-read Collection|GroupMailRecipient[] $groupMailRecipients
 * @property-read int|null $group_mail_recipients_count
 * @method static Builder|GroupMail newModelQuery()
 * @method static Builder|GroupMail newQuery()
 * @method static Builder|GroupMail query()
 * @method static Builder|GroupMail whereBody($value)
 * @method static Builder|GroupMail whereDate($value)
 * @method static Builder|GroupMail whereId($value)
 * @method static Builder|GroupMail whereIsConfirm($value)
 * @method static Builder|GroupMail whereSubject($value)
 * @method static Builder|GroupMail whereType($value)
 * @mixin Eloquent
 */
class GroupMail extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'date',
        'subject',
        'body',
        'is_confirm'
    ];

    /**
     * @return HasMany
     */
    public function groupMailAttachments(): HasMany
    {
        return $this->hasMany(GroupMailAttachment::class);
    }

    /**
     * @return HasMany
     */
    public function groupMailRecipients(): HasMany
    {
        return $this->hasMany(GroupMailRecipient::class);
    }
}
