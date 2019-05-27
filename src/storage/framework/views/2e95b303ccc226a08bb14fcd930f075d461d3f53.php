<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/css/multiple-select.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="main">
        <div class="inner-heading">
            <div class="container">
                <?php echo e(trans('messages.Add Dashboard Category')); ?>

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 p-b-20">
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
                   <form action="<?php echo e(url('/dashboard-categories')); ?>" data-parsley-validate="" method="post">
                       <?php echo csrf_field(); ?>
                       <div class="box m-b-30"> 
                        <div class="row">
                            <div class="form-group col-12 col-lg-6 col-md-6">
                                <label>Dashboard Category Name *</label>
                                <input type="text" required="" data-parsley-required-message="Please fill in a Dashboard Category Name" class="form-control" maxlength="50"  placeholder="Dashboard Category Name" name="dashcatname">
                                <?php if($errors->has('dashcatname')): ?>
                                <span class="errors"><?php echo e($errors->first('dashcatname')); ?></span>  
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-12 col-lg-6 col-md-6">
                                <label>Dashboards</label>
                                <select class="form-control" name="dashboard[]" id="dashboard" multiple>
                                    <?php if(count($dashboard)): ?>
                                    <option disabled></option>
                                    <?php $__currentLoopData = $dashboard; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dash): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($dash->id); ?>"><?php echo e($dash->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php if(!count($dashboard)): ?>
                                <small class="errors">No Dashboards found – please create one</small>
                                <?php endif; ?>
                            </div>
                        </div>
                      </div>
                      <div class="form-group col-12 text-center">
                        <button type="submit" class="btn btn-theme w-200">Add</button>
                        <a href="<?php echo e(url('/dashboard-categories')); ?>" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                      </div>  
                    </form>
                </div>
                
            </div>
        </div>
    </div>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('public/js/multiple-select.js')); ?>"></script>
<script>
        $("#dashboard").multipleSelect({
            placeholder: "Select Dashboard"
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>