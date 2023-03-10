<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a style="display: flex; justify-content : center; width : 100%" class=" m-0 pt-2" href="<?php echo e(route('home')); ?>"
            target="_blank">
            <img src="./img/logos/logo.png" style="width: 180px" alt="main_logo">
            <!-- <span class="ms-1 font-weight-bold">Argon Dashboard 2 Laravel</span> -->
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::currentRouteName() == 'home' ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-bullet-list-67" style="color: #de3435;"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Reports</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::currentRouteName() == 'green-driving' ? 'active' : ''); ?>" href="<?php echo e(route('green-driving')); ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Green Driving</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::currentRouteName() == 'performance' ? 'active' : ''); ?>" href="<?php echo e(route('performance')); ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Performance</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Route::currentRouteName() == 'temperature' ? 'active' : ''); ?>" href="<?php echo e(route('temperature')); ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Temperature</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<?php /**PATH F:\Laravel\Laravel-GPS-Tracking-Dashboard\resources\views/layouts/navbars/auth/sidenav.blade.php ENDPATH**/ ?>