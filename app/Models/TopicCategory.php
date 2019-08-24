<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\TopicCategory
 *
 * @property int $id
 * @property int $bu_id
 * @property string $name 名稱
 * @property string|null $description 描述
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Topic[] $topic
 * @method static Builder|TopicCategory newModelQuery()
 * @method static Builder|TopicCategory newQuery()
 * @method static Builder|TopicCategory query()
 * @method static Builder|TopicCategory whereBuId($value)
 * @method static Builder|TopicCategory whereCreatedAt($value)
 * @method static Builder|TopicCategory whereDescription($value)
 * @method static Builder|TopicCategory whereId($value)
 * @method static Builder|TopicCategory whereName($value)
 * @method static Builder|TopicCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TopicCategory extends Model
{
    protected $fillable = [
        'bu_id', 'name', 'description',
    ];

    public function topic()
    {
        return $this->hasMany(Topic::class);
    }
}
