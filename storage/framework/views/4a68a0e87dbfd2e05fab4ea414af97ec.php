<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

?>

<div class="flex flex-col gap-6">
    <div class="absolute end-4 top-4 md:end-8 md:top-8 z-30">
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 border dark:border-neutral-800 dark:hover:bg-neutral-800">
                Home
            </a>
        </div>
    <?php if (isset($component)) { $__componentOriginal4273a2be7fa507434126887b582bb175 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4273a2be7fa507434126887b582bb175 = $attributes; } ?>
<?php $component = App\View\Components\AuthHeader::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AuthHeader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'เข้าสู่ระบบ','description' => 'กรุณาใส่ข้อมูลเพื่อเข้าสู่ระบบ']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4273a2be7fa507434126887b582bb175)): ?>
<?php $attributes = $__attributesOriginal4273a2be7fa507434126887b582bb175; ?>
<?php unset($__attributesOriginal4273a2be7fa507434126887b582bb175); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4273a2be7fa507434126887b582bb175)): ?>
<?php $component = $__componentOriginal4273a2be7fa507434126887b582bb175; ?>
<?php unset($__componentOriginal4273a2be7fa507434126887b582bb175); ?>
<?php endif; ?>

    <!-- Session Status -->
    <?php if (isset($component)) { $__componentOriginal6da4f549a5e837ad34d208a4725c54bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6da4f549a5e837ad34d208a4725c54bb = $attributes; } ?>
<?php $component = App\View\Components\AuthSessionStatus::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AuthSessionStatus::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-center','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6da4f549a5e837ad34d208a4725c54bb)): ?>
<?php $attributes = $__attributesOriginal6da4f549a5e837ad34d208a4725c54bb; ?>
<?php unset($__attributesOriginal6da4f549a5e837ad34d208a4725c54bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6da4f549a5e837ad34d208a4725c54bb)): ?>
<?php $component = $__componentOriginal6da4f549a5e837ad34d208a4725c54bb; ?>
<?php unset($__componentOriginal6da4f549a5e837ad34d208a4725c54bb); ?>
<?php endif; ?>

    <form wire:submit="login" class="flex flex-col gap-4">
        <div>
            <label for="login_username" class="block text-sm font-medium text-gray-700">Username</label>
            <input wire:model.defer="username" 
                   id="login_username" 
                   type="text" 
                   placeholder="Username" 
                   required 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> 
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div>
            <label for="login_password" class="block text-sm font-medium text-gray-700">Password</label>
            <input wire:model.defer="password" 
                   id="login_password" 
                   type="password" 
                   placeholder="Password" 
                   required 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> 
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div class="flex items-center">
            <input wire:model.defer="remember" 
                   id="remember" 
                   type="checkbox" 
                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
            <label for="remember" class="ml-2 block text-sm text-gray-900">
                จดจำฉันไว้
            </label>
        </div>

        <button type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            เข้าสู่ระบบ
        </button>
    </form>

    <div class="text-center space-y-2">
        <a href="<?php echo e(route('password.request')); ?>" wire:navigate class="text-sm text-blue-600 hover:text-blue-500">
            ลืมรหัสผ่าน?
        </a>
        <div class="text-sm text-gray-600">
            ยังไม่มีบัญชี? <a href="<?php echo e(route('register')); ?>" wire:navigate class="text-blue-600 hover:text-blue-500">สมัครสมาชิก</a>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\watakacha-project\resources\views\livewire/auth/login.blade.php ENDPATH**/ ?>