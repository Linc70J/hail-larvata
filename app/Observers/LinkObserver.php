<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // 在儲存時清空 cache_key 對應的Cache
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}
