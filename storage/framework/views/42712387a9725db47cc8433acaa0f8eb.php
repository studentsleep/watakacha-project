<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        <nav class="flex items-center justify-end gap-4">
            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary">Login</a>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-primary">Register</a>
        </nav>
    </header>

    <main class="flex flex-col items-center justify-center w-full">
        <h1 class="mb-3 fw-medium fs-4">Watakacha Wedding & Studio Chiang Mai</h1>
        <a href="<?php echo e(route('manager.index')); ?>" class="btn btn-danger mt-3">
            Manager
        </a>
    </main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\watakacha-project\resources\views/welcome.blade.php ENDPATH**/ ?>