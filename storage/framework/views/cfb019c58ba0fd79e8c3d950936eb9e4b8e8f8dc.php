<div class="px-4 pt-4">
    <?php if($message = session()->has('succes')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p class="text-white mb-0"><?php echo e(session()->get('succes')); ?></p>
        </div>
    <?php endif; ?>
    <?php if($message = session()->has('error')): ?>
        <div class="alert alert-danger" role="alert">
            <p class="text-white mb-0"><?php echo e(session()->get('error')); ?></p>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH F:\Laravel\Laravel-GPS-Tracking-Dashboard\resources\views/components/alert.blade.php ENDPATH**/ ?>