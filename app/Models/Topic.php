<?php

namespace App\Models;

use App\Models\Traits\OrderScopeHelper;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * App\Models\Topic
 *
 * @property int $id
 * @property int $bu_id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property int $category_id
 * @property int $reply_count
 * @property int $view_count
 * @property int $last_reply_user_id
 * @property int $order
 * @property string $excerpt
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read TopicCategory $topicCategory
 * @property-read Collection|TopicReply[] $topicReplies
 * @property-read User $user
 * @method static Builder|Topic newModelQuery()
 * @method static Builder|Topic newQuery()
 * @method static Builder|Model ordered()
 * @method static Builder|Topic query()
 * @method static Builder|Topic recent()
 * @method static Builder|Topic recentHot()
 * @method static Builder|Topic recentReplied()
 * @method static Builder|Topic whereBody($value)
 * @method static Builder|Topic whereBuId($value)
 * @method static Builder|Topic whereCategoryId($value)
 * @method static Builder|Topic whereCreatedAt($value)
 * @method static Builder|Topic whereExcerpt($value)
 * @method static Builder|Topic whereId($value)
 * @method static Builder|Topic whereLastReplyUserId($value)
 * @method static Builder|Topic whereOrder($value)
 * @method static Builder|Topic whereReplyCount($value)
 * @method static Builder|Topic whereSlug($value)
 * @method static Builder|Topic whereTitle($value)
 * @method static Builder|Topic whereUpdatedAt($value)
 * @method static Builder|Topic whereUserId($value)
 * @method static Builder|Topic whereViewCount($value)
 * @method static Builder|Topic withOrder($order)
 * @mixin Eloquent
 */
class Topic extends Model
{
    use OrderScopeHelper;

    protected $hot_days = 30;    // 多少天内的熱門話題

    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function topicReplies()
    {
        return $this->hasMany(TopicReply::class);
    }

    public function topicCategory()
    {
        return $this->belongsTo(TopicCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的讀取邏輯
        switch ($order) {
            case 'recent':
                $query = $this->recent();
                break;
            case 'hot':
                $query = $this->recentHot();
                break;
            default:
                $query = $this->recentReplied();
                break;
        }
        // 預加载防止 N+1 問題
        return $query->with('user', 'topicCategory');
    }

    public function scopeRecentHot(Builder $query)
    {
        $dataTime =  Carbon::now()->subDays($this->hot_days)->toDateTimeString();
        return $query->orderBy(DB::raw("(select count(*) from `replies` where `topics`.`id` = `replies`.`topic_id` and `replies`.`updated_at` > '${$dataTime}')"), 'desc');
    }

    public function scopeRecentReplied(Builder $query)
    {
        // 當話題有新回覆時，我們將更新話題的 reply_count 屬性，
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent(Builder $query)
    {
        // 按照創建時間排序
        return $query->orderBy('created_at', 'desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
