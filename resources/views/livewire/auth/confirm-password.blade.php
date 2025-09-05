<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-mary-card class="bg-base-100">
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-semibold text-primary">{{ __('Confirm password') }}</h1>
            <p class="text-sm text-base-content/70">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>
    </x-mary-card>

    @if (session('status'))
        <x-mary-alert color="primary" class="text-center">
            {{ session('status') }}
        </x-mary-alert>
    @endif

    <form method="POST" wire:submit="confirmPassword" class="flex flex-col gap-6">
        <x-mary-input
            wire:model="password"
            label="{{ __('Password') }}"
            type="password"
            required
            autocomplete="new-password"
            placeholder="{{ __('Password') }}"
        />

        <x-mary-button color="primary" type="submit" class="w-full">
            {{ __('Confirm') }}
        </x-mary-button>
    </form>
</div>
