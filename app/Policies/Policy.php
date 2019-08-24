<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        // 如果用戶擁有管理内容的權限的话，即授權通過
        if ($user->can('manage_contents')) {
            return true;
        }
    }
}
