<?php

namespace App\Models;

use App\Models\Traits\OrderScopeHelper;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TopicReply
 *
 * @property-read Topic $topic
 * @property-read User $user
 * @method static Builder|TopicReply newModelQuery()
 * @method static Builder|TopicReply newQuery()
 * @method static Builder|Model ordered()
 * @method static Builder|TopicReply query()
 * @method static Builder|Model recent()
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
