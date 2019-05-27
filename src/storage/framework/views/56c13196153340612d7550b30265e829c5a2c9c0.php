<div class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="<?php echo e(url('/dashboard')); ?>">
                    <img src="<?php echo e(asset('public/images/logo.png')); ?>" alt="logo" style="width: 210px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav ml-auto">
                        <li class="<?php echo e(Request::segments()[0]=== 'dashboard' ? 'nav-item active' : 'nav-item'); ?>"  >
                            <a class="nav-link" href="<?php echo e(url('/dashboard')); ?>"><?php echo e(trans('messages.Dashboard')); ?></a>
                        </li>
                        <?php if(auth()->user()->role === 'admin'): ?>
                        <li class="<?php echo e(Request::segments()[0]=== 'dashboard-categories' ? 'nav-item active' : 'nav-item'); ?>">
                            <a class="nav-link" href="<?php echo e(url('/dashboard-categories')); ?>"><?php echo e(trans('messages.Dashboard Categories')); ?></a>
                        </li>
                        <li class="<?php echo e(Request::segments()[0]=== 'users'  ? 'nav-item active' : 'nav-item'); ?>">
                            <a class="nav-link" href="<?php echo e(url('/users')); ?>"><?php echo e(trans('messages.Users')); ?></a>
                        </li>
                        <li class="<?php echo e(Request::segments()[0]=== 'user-groups' ? 'nav-item active' : 'nav-item'); ?>">
                            <a class="nav-link" href="<?php echo e(url('/user-groups')); ?>"><?php echo e(trans('messages.User Groups')); ?></a>
                        </li>
                        <?php endif; ?>
                        <li class="<?php echo e(Request::segments()[0]=== 'edit-account' ? 'nav-item active' : 'nav-item'); ?>">
                            <a class="nav-link" href="<?php echo e(url('/edit-account')); ?>"><?php echo e(trans('messages.Account')); ?></a>
                        </li>
                        <li class="nav-item dropdown profile-dropdown <?php echo e(Request::segments()[0]=== 'change-password' ? 'active' : ' '); ?>">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo e(ucfirst(auth()->user()->firstname)); ?>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <!-- <a class="dropdown-item" href="<?php echo e(url('/change-password')); ?>">Change Password</a> -->
                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
</div>