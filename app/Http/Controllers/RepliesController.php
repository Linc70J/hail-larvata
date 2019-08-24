<?php

namespace App\Http\Controllers;

use App\Models\TopicReply;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, TopicReply $reply)
    {
        $reply->content = $request->get('content');
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->get('topic_id');
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '回覆成功！');
    }

    public function destroy(TopicReply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '成功刪除回覆！');
    }
}
