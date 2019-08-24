<?php

namespace App\Observers;

use App\Models\TopicReply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicReplyObserver
{
    public function created(TopicReply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);

        // 如果評論的作者不是話題的作者，才需要通知
        if ( ! $reply->user->isAuthorOf($topic)) {
            $topic->user->notify(new TopicReplied($reply));
        }
    }

    public function creating(TopicReply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(TopicReply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}
