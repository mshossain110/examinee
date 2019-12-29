<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Examinee" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{asset('images/fabicon.png')}}"/>

    <!-- Styles -->

    <link rel="stylesheet" href="{{ asset('css/lib/jquery.fancybox.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        @if ( isset($token ))
            window.localStorage['auth_token'] = '{{ $token }}'
        @endif

        @if (Session::has('token'))
            window.localStorage['auth_token'] = '{{ Session::get("token") }}'
        @endif

        window.Examinee = {}


        @if(Auth::check())
            window.Examinee.user = @json(Auth::user())
        @endif
    </script>
    @stack('head')
</head>