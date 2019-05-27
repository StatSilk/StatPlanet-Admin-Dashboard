<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'StatSilk')); ?></title>
    <!-- Styles -->
    <link href="<?php echo e(asset('public/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/parsley.css')); ?>" rel="stylesheet">
 <?php $__env->startSection('css'); ?>   
 <?php echo $__env->yieldSection(); ?>
</head>
<body class="bg-splashscreen">
    <?php echo $__env->yieldContent('content'); ?>

<script src="<?php echo e(asset('public/js/app.js')); ?>" ></script>
<script src="<?php echo e(asset('public/js/bootstrap.min.js')); ?>" ></script>
<script src="<?php echo e(asset('public/js/parsley.min.js')); ?>" ></script>
<?php $__env->startSection('js'); ?>   
<?php echo $__env->yieldSection(); ?>
</body>


</html>
