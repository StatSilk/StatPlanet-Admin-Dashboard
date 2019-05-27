
<?php $__env->startSection('content'); ?>
    <div class="main m-b-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="text-center p-b-15"><img src="<?php echo e(asset('public/images/logo.png')); ?>" alt="logo" style="width: 280px;"></div>
                     <?php if(session()->has('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session()->get('success')); ?>

                    </div>
                    <?php endif; ?>
                    <?php if(session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session()->get('error')); ?>

                        </div>
                    <?php endif; ?>
                    <div class="login-heading-top">
                        <h3><?php echo e(Config::get('constant.title')); ?></h3>
                        <h5><?php echo e(Config::get('constant.subtitle')); ?></h5>
                    </div>
                   <form class="box login" data-parsley-validate="" method="POST" action="<?php echo e(route('login')); ?>" aria-label="<?php echo e(__('Login')); ?>">
                   <?php echo csrf_field(); ?>
                        <h3 class="heading text-center">Login</h3>
                        <div class="row">
                            <div class="form-group col-12">
                                <input id="identity" type="text" class="form-control<?php echo e($errors->has('identity') ? ' is-invalid' : ''); ?>" required="" data-parsley-required-message="Username or Email is required." name="identity"
                                value="<?php echo e(old('identity')); ?>" autofocus placeholder="Username or Email" autofocus>

                                <?php if($errors->has('identity')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('identity')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group col-12">
                                <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" required="" data-parsley-required-message="Password is required." name="password"  placeholder="Password">
                                <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class=" form-group col-12">
                                <button type="submit" class="btn btn-theme btn-block btn-lg">Login</button>
                            </div>
                            <div class="col-12 text-center">
                                <a href="<?php echo e(route('password.request')); ?>">Forgot your password?</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-7 col-md-10">
                    <p class="text-center p-t-20"><?php echo e(Config::get('constant.description')); ?></p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-7 col-md-10 social">
                	<?php $__currentLoopData = Config::get('constant.images'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                		<a href="<?php echo e($image['link']); ?>" target="_blank"><img src="<?php echo e(asset('public/images').'/'.$image['image']); ?>" style="width: 40px;"></a>
                	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-t-30">
                    <p class="text-center"><?php echo e(Config::get('constant.footer-text')); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.splash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>