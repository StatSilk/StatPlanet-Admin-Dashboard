<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="main">
    <div class="inner-heading">
        <div class="container">
            <?php echo e(trans('messages.Add Dashboard')); ?>

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
                <form action="<?php echo e(url('/dashboard')); ?>" data-parsley-validate="" method="post" enctype="multipart/form-data">
                 <?php echo csrf_field(); ?>
                 <div class="box m-b-30"> 
                    <div class="row">
                        <div class="form-group col-12 col-lg-6 col-md-6">
                            <label>Name *</label>
                            <input type="text" required="" class="form-control"  placeholder="Dashboard Name" autocomplete='name' name="name">
                            <?php if($errors->has('name')): ?>
                            <span class="errors"><?php echo e($errors->first('name')); ?></span>  
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-12 col-lg-6 col-md-6">
                            <label>Category</label>
                            <select name="dashcat" class="form-control" >
                                <option value="">Select Dashboard Category</option>
                                <?php $__currentLoopData = $dashcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-12 col-lg-6 col-md-6">
                            <label>Folder Name *</label>
                            <select required=""  name="foldername" class="form-control" >
                                <option value="">Select Folder Name</option>
                                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($file); ?>"><?php echo e($file); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-12 col-lg-6 col-md-6">
                            <label>Link </label>
                            <input type="text" class="form-control" placeholder="Dashboard Web Link" data-parsley-type="url" autocomplete='dashboard_link' data-parsley-type-message="Please insert a valid link" name="dashboard_link">
                        </div>
                        <div class="form-group col-12 col-lg-6 col-md-6">
                            <label>Description</label>
                            <textarea class="form-control" rows="1" autocomplete='description' placeholder="Dashboard Description" name="description"></textarea>
                        </div>
                        
                    </div>
                </div>
                <div class="form-group col-12 text-center">
                    <button type="submit" id="submit" class="btn btn-theme w-200">Add</button>
                    <a href="<?php echo e(url('/dashboard')); ?>" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                </div>  
            </form>
        </div>
    </div>
</div>
</div>
<?php $__env->startSection('js'); ?>
<!-- <script>
    $(function () {
        $("body").on("change", "#fileUpload", function () {
            var allowedFiles = [".txt", ".csv"];
            var fileUpload = $("#fileUpload");
            var lblError = $("#lblError");
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
            if (!regex.test(fileUpload.val().toLowerCase())) {
                lblError.html("Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.");
                return false;
            }
            lblError.html('');
            return true;
        });
    });
</script> -->
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>