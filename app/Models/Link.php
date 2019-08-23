<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Cache;
use Illuminate\Support\Carbon;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property int $bu_id
 * @property string $title 連結的描述
 * @property string $link 連結的URI
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Link newModelQuery()
 * @method static Builder|Link newQuery()
 * @method static Builder|Link query()
 * @method static Builder|Link whereBuId($value)
 * @method static Builder|Link whereCreatedAt($value)
 * @method static Builder|Link whereId($value)
 * @method static Builder|Link whereLink($value)
 * @method static Builder|Link whereTitle($value)
 * @method static Builder|Link whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Link extends Model
{
    protected $fillable = ['bu_id', 'title', 'link'];

    public $cache_key = 'links';
    protected $cache_expire_in_minutes = 1440;

    public function getAllCached()
    {
        // 嘗試從Cache中取出 cache_key 對應的資料。如果能取得，便直接返回資料。
        // 否則從取出資料庫取出Links所有資料，返回的同時Cache資料。
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function(){
            return $this->all();
        });
    }
}
