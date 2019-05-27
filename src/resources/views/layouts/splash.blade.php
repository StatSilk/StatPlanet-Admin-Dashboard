<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StatSilk') }}</title>
    <!-- Styles -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/parsley.css') }}" rel="stylesheet">
 @section('css')   
 @show
</head>
<body class="bg-splashscreen">
    @yield('content')
{{-- <script src="{{ asset('js/jquery-3.3.1.js') }}" ></script> --}}
<script src="{{ asset('public/js/app.js') }}" ></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}" ></script>
<script src="{{ asset('public/js/parsley.min.js') }}" ></script>
@section('js')   
@show
</body>


</html>
