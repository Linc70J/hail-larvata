<?php

namespace App\Policies;

use App\Models\TopicReply;
use App\Models\User;

class TopicReplyPolicy extends Policy
{
    public function destroy(User $user, TopicReply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
