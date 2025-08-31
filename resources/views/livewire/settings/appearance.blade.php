<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <x-mary-radio name="appearance" value="light" wire:model.live="appearance" class="radio-primary" />
                <x-mary-icon name="o-sun" class="w-4 h-4 text-primary" />
                <span>{{ __('Light') }}</span>
            </label>

            <label class="flex items-center gap-2 cursor-pointer">
                <x-mary-radio name="appearance" value="dark" wire:model.live="appearance" class="radio-primary" />
                <x-mary-icon name="o-moon" class="w-4 h-4 text-primary" />
                <span>{{ __('Dark') }}</span>
            </label>

            <label class="flex items-center gap-2 cursor-pointer">
                <x-mary-radio name="appearance" value="system" wire:model.live="appearance" class="radio-primary" />
                <x-mary-icon name="o-computer-desktop" class="w-4 h-4 text-primary" />
                <span>{{ __('System') }}</span>
            </label>
        </div>
    </x-settings.layout>
</section>
