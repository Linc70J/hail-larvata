<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>@yield('title', env('APP_NAME', 'Laravel')) - {{ config('administrator.title') }}</title>

    <link href="{{asset('packages/summerblue/administrator/css/app.css')}}" media="all" type="text/css"
          rel="stylesheet">
    <link href="{{asset('packages/summerblue/administrator/css/main-extended.css')}}" media="all" type="text/css"
          rel="stylesheet">
    <link href="{{asset('packages/summerblue/administrator/css/browsers/lte-ie9.css')}}" media="all" type="text/css"
          rel="stylesheet">
    @foreach (\App\Administrator\Admin::getCSS() as $url)
        <link href="{{$url}}" media="all" type="text/css" rel="stylesheet">
    @endforeach
</head>
<body>
<div id="wrapper">
    @include('administrator.partials.header')

    @yield('content')

    @include('administrator.partials.footer')
</div>

<script src="{{asset('packages/summerblue/administrator/js/base.js')}}"></script>
@foreach (\App\Administrator\Admin::getScript() as $url)
    <script src="{{$url}}"></script>
@endforeach
<script src="{{asset('packages/summerblue/administrator/js/app.js')}}"></script>
</body>
</html>
