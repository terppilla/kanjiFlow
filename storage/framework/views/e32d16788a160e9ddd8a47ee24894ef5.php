<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@200..900&family=Noto+Sans+SC:wght@100..900&display=swap" rel="stylesheet">

        <title><?php echo e(config('app.name', 'KanjiFlow')); ?></title>      
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/forms.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/user.css')); ?>">
        
    
    </head>
    <body class="font-sans antialiased layout-app-body">
        <div class="layout-app-wrap">
            <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php if(isset($header)): ?>
                <header class="page-header">
                    <div class="container">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <main class="page-content layout-app-main">
                <?php echo e($slot); ?>

            </main>
        </div>

        <?php if (! ($hideFooter)): ?>
            <footer class="site-footer" role="contentinfo">
                <div class="site-footer-inner">
                    <div class="site-footer-brand">
                        <p class="site-footer-title"><?php echo e(config('app.name', 'KanjiFlow')); ?></p>
                        <p class="site-footer-tagline">Изучение китайских иероглифов по уровням HSK и в ваших коллекциях.</p>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <nav class="site-footer-nav" aria-label="Разделы сайта">
                            <a href="<?php echo e(route('dashboard')); ?>">Дашборд</a>
                            <a href="<?php echo e(route('learning.select-level')); ?>">Обучение</a>
                            <a href="<?php echo e(route('articles.index')); ?>">Статьи</a>
                            <a href="<?php echo e(route('collections.index')); ?>">Коллекции</a>
                            <a href="<?php echo e(route('profile.edit')); ?>">Профиль</a>
                            <?php if(auth()->user()?->isAdmin()): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>">Админ-панель</a>
                            <?php endif; ?>
                        </nav>
                    <?php endif; ?>

                    <div class="site-footer-bottom">
                        <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'KanjiFlow')); ?>. Все права защищены.</p>
                    </div>
                </div>
            </footer>
        <?php endif; ?>
    </body>
</html>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/layouts/app.blade.php ENDPATH**/ ?>