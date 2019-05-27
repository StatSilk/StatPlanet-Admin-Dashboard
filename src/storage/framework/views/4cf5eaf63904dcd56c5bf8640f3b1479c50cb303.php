<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/css/multiple-select.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="main">
    <div class="inner-heading">
        <div class="container">
            Add User Group
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
                <form action="<?php echo e(url('/user-groups')); ?>" data-parsley-validate="" method="post">
                 <?php echo csrf_field(); ?>
                 <div class="box m-b-30"> 
                    <div class="row">
                        <div class="form-group col-12 col-lg-4 col-md-4">
                            <label>User Group Name*</label>
                            <input type="text" required="" class="form-control" maxlength="50"  placeholder="User Group Name" data-parsley-required-message="Please fill in a User Group Name" name="usergroupname">
                            <?php if($errors->has('usergroupname')): ?>
                            <span class="errors"><?php echo e($errors->first('usergroupname')); ?></span>  
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-12 col-lg-4 col-md-4">
                            <label>Dashboard Categories</label>
                            <select class="form-control" name="dashcat[]" id="dashcat" multiple>
                                <?php if(count($dashcat)): ?>
                                <option disabled></option>
                                <?php $__currentLoopData = $dashcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dashcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dashcategory->id); ?>"><?php echo e($dashcategory->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <?php if(!count($dashcat)): ?>
                            <small class="errors">No Dashboard Categories found – please create one</small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-12 col-lg-4 col-md-4">
                            <label>Users</label>
                            <select class="form-control" name="users[]" id="users" multiple>
                                <?php if(count($users)): ?>
                                <option disabled></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->firstname.' '.$user->lastname); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <?php if(!count($users)): ?>
                            <small class="errors">No Users found – please create one</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 text-center">
                    <button type="submit" class="btn btn-theme w-200">Add</button>
                    <a href="<?php echo e(url('/user-groups')); ?>" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                </div>  
            </form>
        </div>
        
    </div>
</div>
</div>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('public/js/multiple-select.js')); ?>"></script>
<script>
    $("#users").multipleSelect({
        placeholder: "Select Users"
    });
    $("#dashcat").multipleSelect({
        placeholder: "Select Dashboard Category"
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>