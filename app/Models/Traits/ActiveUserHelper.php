<?php

namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\TopicReply;
use Arr;
use Carbon\Carbon;
use Cache;
use DB;

trait ActiveUserHelper
{
    // 用於存取臨時用戶資料
    protected $users = [];

    // 配置信息
    protected $topic_weight = 4; // 話題權重
    protected $reply_weight = 1; // 回覆權重
    protected $pass_days = 7;    // 多少天内發表過内容
    protected $user_number = 6;  // 取出来多少用戶

    // 相关配置
    protected $cache_key = 'active_users';
    protected $cache_expire_in_minutes = 65;

    public function getActiveUsers()
    {
        // 嘗試從Cache中取出 cache_key 對應的資料。如果能取得，便直接返回資料。
        // 否則從取出資料庫取出活躍用戶所有資料，返回的同時Cache資料。
        return Cache::remember($this->cache_key, $this->cache_expire_in_minutes, function(){
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活躍用戶列表
        $active_users = $this->calculateActiveUsers();
        // 並加以Cache
        $this->cacheActiveUsers($active_users);
    }

    private function calculateActiveUsers()
    {
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        // 按照得分排序
        $users = Arr::sort($this->users, function ($user) {
            return $user['score'];
        });

        // 我们需要的是倒序，高分靠前，第二个参数為保持數組的 KEY 不變
        $users = array_reverse($users, true);

        // 只獲取我们想要的數量
        $users = array_slice($users, 0, $this->user_number, true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            // 找尋一下是否可以找到用戶
            $user = $this->find($user_id);

            // 如果資料庫裡有該用戶的话
            if ($user) {

                // 將此用戶實體放入集合的末端
                $active_users->push($user);
            }
        }

        // 返回資料
        return $active_users;
    }

    private function calculateTopicScore()
    {
        // 從話題資料表裡面取出限定時間範圍（$pass_days）內，有發表過回覆的用戶
        // 並且同時取出用戶此段時間內發布話題的數量
        $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();
        // 根據話題數量計算得分
        foreach ($topic_users as $value) {
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }
    }

    private function calculateReplyScore()
    {
        // 從回覆資料表裡面取出限定時間範圍（$pass_days）內，有發表過回覆的用戶
        // 並且同時取出用戶此段時間內發布回覆的數量
        $reply_users = TopicReply::query()->select(DB::raw('user_id, count(*) as reply_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();
        // 根據回覆數量計算得分
        foreach ($reply_users as $value) {
            $reply_score = $value->reply_count * $this->reply_weight;
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $reply_score;
            } else {
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    private function cacheActiveUsers($active_users)
    {
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }
}
