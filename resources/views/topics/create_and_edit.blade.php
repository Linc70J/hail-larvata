@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">
                    <h2 class="text-center">
                        <i class="glyphicon glyphicon-edit"></i>
                        @if($topic->id)
                            編輯話題
                        @else
                            發表新話題
                        @endif
                    </h2>

                    <hr>

                    @include('common.error')

                    <form action="{{ $topic->id ? route('topics.store') : route('topics.store') }}" method="POST"
                          accept-charset="UTF-8">
                        @if($topic->id) <input type="hidden" name="_method" value="PUT"> @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <input class="form-control" type="text" name="title"
                                   value="{{ old('title', $topic->title ) }}" placeholder="請填寫標題" required/>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="datetime-local" name=""
                                   value="" placeholder="請填寫發布時間" required/>
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="topic_category_id" required>
                                <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>請選擇話題分類</option>
                                @foreach ($categories as $value)
                                    <option
                                        value="{{ $value->id }}" {{ $topic->topicCategory_id == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <textarea name="body" class="form-control" id="editor" rows="3" placeholder="請填入至少三个字符的内容。"
                                      required>{{ old('body', $topic->body ) }}</textarea>
                        </div>

                        <div class="form-group">
                            <input type="checkbox"> 置頂
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"
                                                                                aria-hidden="true"></span> 儲存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

    <script>
        $(document).ready(function () {
            var editor = new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('topics.upload_image') }}',
                    params: {_token: '{{ csrf_token() }}'},
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                },
                pasteImage: true,
            });
        });
    </script>

@stop
