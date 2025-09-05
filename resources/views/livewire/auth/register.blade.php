<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, 'ends_with:@uom.lk'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('verification.notice', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="text-center">
        <h1 class="text-2xl font-bold text-primary">{{ __('Create an account') }}</h1>
        <p class="mt-1 text-sm text-base-content/70">{{ __('Enter your details below to create your account') }}</p>
    </div>

    @if (session('status'))
        <x-mary-alert class="alert-info text-center" title="{{ session('status') }}" />
    @endif

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <x-mary-input
            wire:model="name"
            label="{{ __('Name') }}"
            type="text"
            required
            autofocus
            autocomplete="name"
            placeholder="{{ __('Full name') }}"
        />

        <x-mary-input
            wire:model="email"
            label="{{ __('Email address') }}"
            type="email"
            required
            autocomplete="email"
            placeholder="name.batch@uom.lk"
        />

        <x-mary-input
            wire:model="password"
            label="{{ __('Password') }}"
            type="password"
            required
            autocomplete="new-password"
            placeholder="{{ __('Password') }}"
        />

        <x-mary-input
            wire:model="password_confirmation"
            label="{{ __('Confirm password') }}"
            type="password"
            required
            autocomplete="new-password"
            placeholder="{{ __('Confirm password') }}"
        />

        <div class="flex items-center justify-end">
            <x-mary-button type="submit" class="btn-primary w-full">
                {{ __('Create account') }}
            </x-mary-button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-base-content/70">
        <span>{{ __('Already have an account?') }}</span>
        <a href="{{ route('login') }}" wire:navigate class="link-primary btn-link">
            {{ __('Log in') }}
        </a>
    </div>
</div>
