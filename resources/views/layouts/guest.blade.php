<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        @include('layouts.partials.fonts')

        @if ($assets === 'landing')
            <link rel="preload" href="{{ asset('img/KANJIFLOW.svg') }}" as="image" type="image/svg+xml" fetchpriority="high">
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
            <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
            <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
        @endif

        @stack('styles')
    </head>
    <body {{ $attributes }}>
        {{ $slot }}
    </body>
</html>
