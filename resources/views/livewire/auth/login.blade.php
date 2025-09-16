<?php
// resources/views/livewire/auth/login.blade.php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.auth')] class extends Component {
    
    public string $username = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'username' => 'required|string',
        'password' => 'required|string',
    ];

    public function login()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages(['username' => __('auth.failed')]);
        }

        RateLimiter::clear($this->throttleKey());
        session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());
        throw ValidationException::withMessages([
            'username' => __('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)])
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->username) . '|' . request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header 
        title="เข้าสู่ระบบ" 
        description="กรุณาใส่ข้อมูลเพื่อเข้าสู่ระบบ" 
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-4">
        <div>
            <label for="login_username" class="block text-sm font-medium text-gray-700">Username</label>
            <input wire:model.defer="username" 
                   id="login_username" 
                   type="text" 
                   placeholder="Username" 
                   required 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('username') 
                <span class="text-sm text-red-600 mt-1">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="login_password" class="block text-sm font-medium text-gray-700">Password</label>
            <input wire:model.defer="password" 
                   id="login_password" 
                   type="password" 
                   placeholder="Password" 
                   required 
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
            @error('password') 
                <span class="text-sm text-red-600 mt-1">{{ $message }}</span> 
            @enderror
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
        <a href="{{ route('password.request') }}" wire:navigate class="text-sm text-blue-600 hover:text-blue-500">
            ลืมรหัสผ่าน?
        </a>
        <div class="text-sm text-gray-600">
            ยังไม่มีบัญชี? <a href="{{ route('register') }}" wire:navigate class="text-blue-600 hover:text-blue-500">สมัครสมาชิก</a>
        </div>
    </div>
</div>