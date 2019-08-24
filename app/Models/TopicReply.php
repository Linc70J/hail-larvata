<?php

namespace App\Models;

use App\Models\Traits\OrderScopeHelper;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TopicReply
 *
 * @property int $id
 * @property int $topic_id
 * @property int $user_id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Topic $topic
 * @property-read User $user
 * @method static Builder|TopicReply newModelQuery()
 * @method static Builder|TopicReply newQuery()
 * @method static Builder|TopicReply ordered()
 * @method static Builder|TopicReply query()
 * @method static Builder|TopicReply recent()
 * @method static Builder|TopicReply whereContent($value)
 * @method static Builder|TopicReply whereCreatedAt($value)
 * @method static Builder|TopicReply whereId($value)
 * @method static Builder|TopicReply whereTopicId($value)
 * @method static Builder|TopicReply whereUpdatedAt($value)
 * @method static Builder|TopicReply whereUserId($value)
 * @mixin Eloquent
 */
class TopicReply extends Model
{
    use OrderScopeHelper;
    protected $fillable = ['content'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
