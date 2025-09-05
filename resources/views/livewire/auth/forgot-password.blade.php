<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'ends_with:@uom.lk'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="text-center">
        <h1 class="text-2xl font-semibold text-base-content">{{ __('Forgot password') }}</h1>
        <p class="mt-1 text-sm text-base-content/70">{{ __('Enter your email to receive a password reset link') }}</p>
    </div>

    @if (session('status'))
        <x-mary-alert class="alert-info text-center">
            {{ session('status') }}
        </x-mary-alert>
    @endif

    <form method="POST" wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <x-mary-input
            wire:model="email"
            label="{{ __('Email Address') }}"
            type="email"
            icon="o-envelope"
            required
            autofocus
            placeholder="name.batch@uom.lk"
        />

        <x-mary-button type="submit" class="btn-primary w-full" spinner="sendPasswordResetLink">
            {{ __('Email password reset link') }}
        </x-mary-button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-base-content/60">
        <span>{{ __('Or, return to') }}</span>
        <x-mary-button :href="route('login')" class="btn-link px-0" wire:navigate>
            {{ __('log in') }}
        </x-mary-button>
    </div>
</div>
