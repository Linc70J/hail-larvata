<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Topic;
use App\Models\TopicCategory;
use App\Models\User;
use App\Models\Link;

class CategoriesController extends Controller
{
    public function show(TopicCategory $category, Request $request, Topic $topic, User $user, Link $link)
    {
        // 讀取分類 ID 關聯的話題
        $topics = $topic->withOrder($request->order)
                        ->where('topic_category_id', $category->id)
                        ->paginate(20);
        // 活躍用戶列表
        $active_users = $user->getActiveUsers();
        // 相關資源連結
        $links = $link->getAllCached();

        return view('topics.index', compact('topics', 'category', 'active_users', 'links'));
    }
}
