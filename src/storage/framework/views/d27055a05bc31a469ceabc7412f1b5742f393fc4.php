<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/css/multiple-select.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="main">
        <div class="inner-heading">
            <div class="container">
                Edit User
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
<?php 
$ugrouparr = [];
foreach($users->userHasUsergroup as $userHasUsergroup){
array_push($ugrouparr,$userHasUsergroup->usergroup_id);
}
?>
                   <?php echo Form::model($users, ['method' => 'PATCH', 'route' => ['users.update', $users->id], 'data-parsley-validate'=>'']); ?>

                       <?php echo e(csrf_field()); ?>

                       <div class="box m-b-30"> 
                        <div class="row">
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>First Name*</label>
                                <input type="text" required="" class="form-control" maxlength="50"  placeholder="First Name" value="<?php echo e($users->firstname); ?>" data-parsley-pattern="/^[a-zA-Z ]{1,50}$/" data-parsley-pattern-message="First name must contain using character" autocomplete='firstname' name="firstname">
                                <?php if($errors->has('firstname')): ?>
                                <span class="errors"><?php echo e($errors->first('firstname')); ?></span>  
                                <?php endif; ?>
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>Last Name*</label>
                                <input type="text" class="form-control" data-parsley-pattern="/^[a-zA-Z ]{1,50}$/" maxlength="50" value="<?php echo e($users->lastname); ?>" data-parsley-pattern-message="Last name must contain using character"  placeholder="Last Name" autocomplete='lastname' required="" name="lastname">
                                <?php if($errors->has('lastname')): ?> 
                                <span class="errors"><?php echo e($errors->first('lastname')); ?></span>  
                                <?php endif; ?>
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>User Name*</label>
                                <input type="text" class="form-control" value="<?php echo e($users->username); ?>" maxlength="75" placeholder="User Name" required="" autocomplete='username' name="username">
                                <?php if($errors->has('username')): ?> 
                                <span class="errors"><?php echo e($errors->first('username')); ?></span>  
                                <?php endif; ?>
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>Email *</label>
                                <input type="email" class="form-control" value="<?php echo e($users->email); ?>" maxlength="50" required=""  name="email" autocomplete='email' placeholder="Email">
                                <?php if($errors->has('email')): ?> 
                                <span class="errors"><?php echo e($errors->first('email')); ?></span>  
                                <?php endif; ?>
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-6">
                                <label>Password</label>
                                <input type="password" class="form-control" id="pwd" data-parsley-pattern="/^(?=.*\d)(?=.*[a-zA-Z]).{6,50}$/" 
                                data-parsley-pattern-message="Your password must contain combination of atleast 6 alphanumeric characters." autocomplete='password'  placeholder="New Password" name="password">
                                <?php if($errors->has('password')): ?> 
                                      <span class="errors"><?php echo e($errors->first('password')); ?></span>  
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group col-12 col-lg-4 col-md-6">
                                <label>User Group</label>
                                <select class="form-control" name="user_group[]" id="lstFruits" multiple>
                                    <?php if(count($usergroup)): ?>
                                    <option disabled></option>
                                    <?php $__currentLoopData = $usergroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ugroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e(in_array($ugroup->id, $ugrouparr)? 'selected':''); ?> value="<?php echo e($ugroup->id); ?>"><?php echo e($ugroup->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php if(!count($usergroup)): ?>
                                <small class="errors">No User Groups found – please create one</small>
                                <?php endif; ?>
                            </div>
                        </div>
                      </div>
                      <div class="form-group col-12 text-center">
                    <button type="submit" class="btn btn-theme w-200">Update</button>
                    <a href="<?php echo e(url('/users')); ?>" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                </div>  
                    <?php echo e(Form::close()); ?>

                </div>
                
            </div>
        </div>
    </div>
<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('public/js/multiple-select.js')); ?>"></script>
<script>
        $("select").multipleSelect({
            placeholder: "Select User Group"
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>