<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GroupMailAttachment
 *
 * @package App\Models
 * @property int $id
 * @property int|null $group_mail_id
 * @property string|null $file_name
 * @property-read Group|null $groupMail
 * @method static Builder|GroupMailAttachment newModelQuery()
 * @method static Builder|GroupMailAttachment newQuery()
 * @method static Builder|GroupMailAttachment query()
 * @method static Builder|GroupMailAttachment whereFileName($value)
 * @method static Builder|GroupMailAttachment whereGroupMailId($value)
 * @method static Builder|GroupMailAttachment whereId($value)
 * @mixin Eloquent
 */
class GroupMailAttachment extends Model
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
        'file_name',
        'group_mail_id'
    ];

    /**
     * @return BelongsTo
     */
    public function groupMail(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_mail_id', 'id');
    }
}
