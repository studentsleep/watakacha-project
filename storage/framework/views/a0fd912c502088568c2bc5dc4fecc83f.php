<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rules;

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
<?php $component->withAttributes(['title' => 'สมัครสมาชิก','description' => 'สร้างบัญชีใหม่เพื่อเข้าใช้งานระบบ']); ?>
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

    <form wire:submit="register" class="flex flex-col gap-4">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input wire:model="username" id="username" type="text" placeholder="Username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">ชื่อ</label>
            <input wire:model="first_name" id="first_name" type="text" placeholder="ชื่อ" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">นามสกุล</label>
            <input wire:model="last_name" id="last_name" type="text" placeholder="นามสกุล" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input wire:model="email" id="email" type="email" placeholder="Email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div>
            <label for="tel" class="block text-sm font-medium text-gray-700">เบอร์โทรศัพท์ (ถ้ามี)</label>
            <input wire:model="tel" id="tel" type="text" placeholder="เบอร์โทรศัพท์" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่าน</label>
            <input wire:model="password" id="password" type="password" placeholder="รหัสผ่าน" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-sm text-red-600 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">ยืนยันรหัสผ่าน</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" placeholder="ยืนยันรหัสผ่าน" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <button type="submit" class="inline-flex h-10 w-full items-center justify-center whitespace-nowrap rounded-md bg-neutral-950 px-4 py-2 text-sm font-medium text-white ring-offset-background transition-colors hover:bg-neutral-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black dark:hover:bg-neutral-200">
            สมัครสมาชิก
        </button>
    </form>
    
    <div class="text-center">
        <span class="text-sm text-gray-600">มีบัญชีแล้ว? </span>
        <a href="<?php echo e(route('login')); ?>" wire:navigate class="text-sm text-blue-600 hover:text-blue-500">เข้าสู่ระบบ</a>
    </div>
</div><?php /**PATH C:\xampp\htdocs\watakacha-project\resources\views\livewire/auth/register.blade.php ENDPATH**/ ?>