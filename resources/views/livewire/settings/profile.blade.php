<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $contact = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->contact = Auth::user()->contact ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'regex:/^[1-9][0-9]{8}$/', 'size:9'],
        ]);

        $user->fill($validated);

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('home', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout heading="{{ __('Profile') }}" subheading="{{ __('Update your name and contact information') }}">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <x-mary-input wire:model="name" label="{{ __('Name') }}" type="text" required autofocus autocomplete="name" />

            <div>
                <x-mary-input wire:model="email" label="{{ __('Email') }}" type="email" readonly disabled class="bg-gray-100" />
                <p class="mt-1 text-sm text-gray-600">{{ __('Email cannot be modified') }}</p>

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <x-mary-alert color="warning" class="mt-4">
                        <div class="flex items-center gap-2">
                            <span>{{ __('Your email address is unverified.') }}</span>
                            <x-mary-button color="primary" variant="link" class="text-sm" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </x-mary-button>
                        </div>
                    </x-mary-alert>

                    @if (session('status') === 'verification-link-sent')
                        <x-mary-alert color="success" class="mt-2">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </x-mary-alert>
                    @endif
                @endif
            </div>

            <x-mary-input
                label="Whatsapp No."
                wire:model="contact"
                prefix="+94"
                type="text"
                placeholder="771234567" />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-mary-button color="primary" type="submit" class="w-full">{{ __('Save') }}</x-mary-button>
                </div>

                <div
                    x-data="{ show: false }"
                    x-on:profile-updated.window="show = true; setTimeout(() => show = false, 2000)"
                    x-show="show"
                >
                    <x-mary-alert color="success" class="py-1 px-2 text-sm">
                        {{ __('Saved.') }}
                    </x-mary-alert>
                </div>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
