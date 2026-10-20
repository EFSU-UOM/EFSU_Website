<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';
    public bool $showDeleteModal = false;

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-10 space-y-6">
    <x-mary-header title="{{ __('Delete account') }}" subtitle="{{ __('Delete your account and all of its resources') }}" class="mb-5" />

    <x-mary-button label="{{ __('Delete account') }}" class="btn-error" wire:click="$set('showDeleteModal', true)" />

    <x-mary-modal wire:model="showDeleteModal" title="{{ __('Are you sure you want to delete your account?') }}" class="backdrop-blur">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <p class="text-sm text-base-content/70">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <x-mary-input wire:model="password" label="{{ __('Password') }}" type="password" />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <x-mary-button label="{{ __('Cancel') }}" wire:click="$set('showDeleteModal', false)" />

                <x-mary-button type="submit" label="{{ __('Delete account') }}" class="btn-error" spinner="deleteUser" />
            </div>
        </form>
    </x-mary-modal>
</section>
