<?php

namespace App\Models\Traits;

use Exception;
use Carbon\Carbon;

trait LastActiveAtHelper
{
    // Cache 相關
    protected $hash_prefix = 'last_active_at_';
    protected $field_prefix = 'user_';

    public function recordLastActiveAt()
    {
        // 獲得今日 Redis Hash表名稱，如：last_active_at_2017-10-21
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名稱，如：user_1
        $field = $this->getHashField();

        // 當前時間，如：2017-10-21 08:35:15
        $now = Carbon::now()->toDateTimeString();

        // 資料寫入 Redis ，字段已存在會被更新
        //Redis::hSet($hash, $field, $now);
    }

    public function syncUserActiveAt()
    {
        // 取得昨日的哈希表名稱，如：last_active_at_2017-10-21
        $hash = $this->getHashFromDateString(Carbon::now()->subDay()->toDateString());

        // 从 Redis 中获取所有哈希表里的数据
        //$dates = Redis::hGetAll($hash);

        // 遍历，并同步到数据库中
        foreach ($dates ?? [] as $user_id => $active_at) {
            // 会将 `user_1` 转换为 1
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有当用戶存在时才更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_active_at = $active_at;
                $user->save();
            }
        }

        // 以数据库为中心的存储，既已同步，即可刪除
        //Redis::del($hash);
    }

    /**
     * @param $value
     * @return Carbon
     * @throws Exception
     */
    public function getLastActiveAtAttribute($value)
    {
        // 获取今日对应的哈希表名稱
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名稱，如：user_1
        $field = $this->getHashField();

        // 優先選擇 Redis 的資料，否則使用資料庫中的
        // $datetime = Redis::hGet($hash, $field) ? : $value;
        $datetime = $value;

        return $datetime ? new Carbon($datetime) : $this->created_at;
    }

    public function getHashFromDateString($date)
    {
        // Hash 表的命名，如：last_active_at_2017-10-21
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名稱，如：user_1
        return $this->field_prefix . $this->id;
    }
}
