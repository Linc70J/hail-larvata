<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OrderScopeHelper
{
    public function scopeRecent(Builder $query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('order', 'desc');
    }
}
