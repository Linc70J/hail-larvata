<?php

namespace App\Observers;

use App\Models\Topic;
use DB;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // XSS 過濾
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成話題摘錄
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function deleted(Topic $topic)
    {
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
