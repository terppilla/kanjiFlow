<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@200..900&family=Noto+Sans+SC:wght@100..900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/landing.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/forms.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/user.css')); ?>">


    </head>
    <body>
        <?php echo e($slot); ?>

    </body>
</html>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/layouts/guest.blade.php ENDPATH**/ ?>