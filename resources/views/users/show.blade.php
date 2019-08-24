
@extends('layouts.app')

@section('title', $user->name . ' 的個人中心')

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="300px" height="300px">
                    </div>
                    <div class="media-body">
                        <h3><strong>{{ $user->name }}</strong></h3>
                        <p>{{ $user->email }}</p>
                        <a href="{{ route('users.edit', Auth::id()) }}" class="btn btn-success btn-block" aria-label="Edit Profile">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 編輯資料
                        </a>
                        <hr>
                        <h4><strong>個人簡介</strong></h4>
                        <p>{{ $user->introduction }}</p>
                        <hr>
                        <h4><strong>註冊於</strong></h4>
                        <p>{{ $user->created_at->diffForHumans() }}</p>
                        <hr>
                        <h4><strong>最後上線</strong></h4>
                        <p title="{{  $user->last_active_at }}">{{ $user->last_active_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <hr>

        {{-- 用戶发布的内容 --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="{{ active_class(if_query('tab', null)) }}">
                        <a href="{{ route('users.show', $user->id) }}">我的話題</a>
                    </li>
                    <li class="{{ active_class(if_query('tab', 'replies')) }}">
                        <a href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">我的回覆</a>
                    </li>
                </ul>
                @if (if_query('tab', 'replies'))
                    @include('users._replies', ['replies' => $user->topicReplies()->with('topic')->recent()->paginate(5)])
                @else
                    @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
                @endif
            </div>
        </div>

    </div>
</div>
@stop
