<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rules;

new #[Layout('components.layouts.auth')] class extends Component {

    public string $username = '';
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $tel = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'tel' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['user_type_id'] = 2; // default member
        $validated['status'] = 'active';

        $user = User::create($validated);

        /*if ($user->user_type_id == 2) {
            $user->member()->create(['point' => 0]);
        }*/

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="absolute end-4 top-4 md:end-8 md:top-8 z-30">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 border dark:border-neutral-800 dark:hover:bg-neutral-800">
                Home
            </a>
        </div>
    <x-auth-header
        title="สมัครสมาชิก"
        description="สร้างบัญชีใหม่เพื่อเข้าใช้งานระบบ"
    />

    <form wire:submit="register" class="flex flex-col gap-4">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input wire:model="username" id="username" type="text" placeholder="Username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('username') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">ชื่อ</label>
            <input wire:model="first_name" id="first_name" type="text" placeholder="ชื่อ" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('first_name') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">นามสกุล</label>
            <input wire:model="last_name" id="last_name" type="text" placeholder="นามสกุล" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('last_name') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input wire:model="email" id="email" type="email" placeholder="Email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('email') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="tel" class="block text-sm font-medium text-gray-700">เบอร์โทรศัพท์ (ถ้ามี)</label>
            <input wire:model="tel" id="tel" type="text" placeholder="เบอร์โทรศัพท์" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('tel') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่าน</label>
            <input wire:model="password" id="password" type="password" placeholder="รหัสผ่าน" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('password') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
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
        <a href="{{ route('login') }}" wire:navigate class="text-sm text-blue-600 hover:text-blue-500">เข้าสู่ระบบ</a>
    </div>
</div>