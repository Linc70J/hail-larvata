<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TopicCategory
 *
 * @method static Builder|TopicCategory newModelQuery()
 * @method static Builder|TopicCategory newQuery()
 * @method static Builder|TopicCategory query()
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
