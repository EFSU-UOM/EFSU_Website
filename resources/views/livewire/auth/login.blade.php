<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        if ($this->isPasswordPwned($this->password)) {
            // Flash a warning message after successful login
            session()->flash('password_breach_warning', ' Your password has appeared in a data breach. For your safety, please change it soon.');
        }

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }




  protected function isPasswordPwned(string $password): bool
{
    $sha1 = strtoupper(sha1($password));
    $prefix = substr($sha1, 0, 5);
    $suffix = substr($sha1, 5);

   try {
        $response = Http::timeout(2)->get("https://api.pwnedpasswords.com/range/{$prefix}");
    } catch (\Exception $e) {
        return false; // fail-safe on timeout or connection error
    }
    if ($response->failed()) {
        return false; // fail-safe
    }

    foreach (explode("\n", $response->body()) as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, ':') === false) {
            continue; // skip empty or malformed lines
        }

        [$hashSuffix, $count] = explode(':', $line, 2); // limit to 2 parts
        if ($suffix === $hashSuffix) {
            return true;
        }
    }

    return false;
}









}; ?>

<div class="flex flex-col gap-6">
    <div class="text-center">
        <h1 class="text-2xl font-bold text-primary">{{ __('Log in to your account') }}</h1>
        <p class="mt-1 text-sm text-base-content/70">{{ __('Enter your email and password below to log in') }}</p>
    </div>

  @if (session('status'))
    <x-mary-alert color="info" class="text-center">
        {{ session('status') }}
    </x-mary-alert>
@endif

    

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
        <x-mary-input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="name.batch@uom.lk"
        />

        <div class="relative">
            <x-mary-input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
            />

            @if (Route::has('password.request'))
                <a class="absolute right-0 top-0 link link-primary text-sm" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <x-mary-checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <x-mary-button color="primary" type="submit" class="w-full">
                {{ __('Log in') }}
            </x-mary-button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-base-content/70">
            <span>{{ __('Don\'t have an account?') }}</span>
            <a href="{{ route('register') }}" class="btn-link link-primary" wire:navigate>{{ __('Sign up') }}</a>
        </div>
    @endif
</div>
