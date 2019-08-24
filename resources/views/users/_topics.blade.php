@if (count($topics))

<ul class="list-group">
    @foreach ($topics as $topic)
        <li class="list-group-item">
            <a href="{{ $topic->link() }}">
                {{ $topic->title }}
            </a>
            <span class="meta pull-right">
                {{ $topic->reply_count }} 回覆
                <span> ⋅ </span>
                {{ $topic->created_at->diffForHumans() }}
            </span>
        </li>
    @endforeach
</ul>

@else
   <div class="empty-block">暫無資料 ~_~ </div>
@endif

{{-- 分页 --}}
{!! $topics->render() !!}