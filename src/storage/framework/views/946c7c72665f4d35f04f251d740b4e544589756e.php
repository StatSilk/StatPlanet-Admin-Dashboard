<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'StatSilk')); ?></title>
    <!-- Styles -->
    <link href="<?php echo e(asset('public/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/style.css')); ?>" rel="stylesheet">
 <?php $__env->startSection('css'); ?>   
 <?php echo $__env->yieldSection(); ?>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
    <footer class="footer">
        <div class="container">
            <span>© Copyright 2018</span>
        </div>
    </footer>
<?php $__env->startSection('js'); ?>   
<?php echo $__env->yieldSection(); ?>
</body>


</html>
