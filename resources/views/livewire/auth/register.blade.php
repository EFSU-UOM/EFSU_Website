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
    public string $contact = '';
    public string $batch = '';
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
            'contact' => ['required', 'string', 'regex:/^[1-9][0-9]{8}$/', 'size:9'],
            'batch' => ['required', 'integer', 'min:0', 'max:99'],
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
            x-on:input="extractBatchFromEmail($event.target.value)"
            hint="Please use your University of Moratuwa email address (not your personal email)"
        />

        <x-mary-input
            wire:model="batch"
            label="Batch"
            type="number"
            required
            placeholder="23"
            min="0"
            max="99"
        />

        <x-mary-input
            label="Whatsapp No."
            wire:model="contact"
            prefix="+94"
            type="text"
            required
            placeholder="771234567" />

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

<script>
function extractBatchFromEmail(email) {
    // Check if email follows the pattern: name.batch@uom.lk
    const emailPattern = /^[^.]+\.(\d{2})@uom\.lk$/;
    const match = email.match(emailPattern);
    
    if (match && match[1]) {
        // Extract the batch number (2 digits)
        const batch = match[1];
        // Update the batch field using Livewire
        @this.set('batch', batch);
    }
}
</script>
