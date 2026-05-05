<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@200..900&family=Noto+Sans+SC:wght@100..900&display=swap" rel="stylesheet">

        <title>{{ config('app.name', 'KanjiFlow') }}</title>      
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        <link rel="stylesheet" href="{{ asset('css/user.css') }}">
        
    
    </head>
    <body class="font-sans antialiased layout-app-body">
        <div class="layout-app-wrap">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="page-header">
                    <div class="container">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="page-content layout-app-main">
                {{ $slot }}
            </main>
        </div>

        @unless ($hideFooter)
            <footer class="site-footer" role="contentinfo">
                <div class="site-footer-inner">
                    <div class="site-footer-brand">
                        <p class="site-footer-title">{{ config('app.name', 'KanjiFlow') }}</p>
                        <p class="site-footer-tagline">Изучение китайских иероглифов по уровням HSK и в ваших коллекциях.</p>
                    </div>

                    @auth
                        <nav class="site-footer-nav" aria-label="Разделы сайта">
                            <a href="{{ route('dashboard') }}">Дашборд</a>
                            <a href="{{ route('learning.select-level') }}">Обучение</a>
                            <a href="{{ route('articles.index') }}">Статьи</a>
                            <a href="{{ route('collections.index') }}">Коллекции</a>
                            <a href="{{ route('profile.edit') }}">Профиль</a>
                            @if (auth()->user()?->isAdmin())
                                <a href="{{ route('admin.dashboard') }}">Админ-панель</a>
                            @endif
                        </nav>
                    @endauth

                    <div class="site-footer-bottom">
                        <p>&copy; {{ date('Y') }} {{ config('app.name', 'KanjiFlow') }}. Все права защищены.</p>
                    </div>
                </div>
            </footer>
        @endunless
    </body>
</html>
