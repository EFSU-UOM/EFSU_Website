<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <x-mary-menu class="menu menu-vertical w-full" title="">
                <x-mary-menu-item link="{{ route('settings.profile') }}" :active="request()->routeIs('settings.profile')" wire:navigate>
                    <x-mary-icon name="o-user" class="w-5 h-5" />
                    {{ __('Profile') }}
                </x-mary-menu-item>
                <x-mary-menu-item link="{{ route('settings.password') }}" :active="request()->routeIs('settings.password')" wire:navigate>
                    <x-mary-icon name="o-key" class="w-5 h-5" />
                    {{ __('Password') }}
                </x-mary-menu-item>
                <x-mary-menu-item link="{{ route('settings.appearance') }}" :active="request()->routeIs('settings.appearance')" wire:navigate>
                    <x-mary-icon name="o-swatch" class="w-5 h-5" />
                    {{ __('Appearance') }}
                </x-mary-menu-item>
        </x-mary-menu>
    </div>

    <x-mary-menu-separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <x-mary-header :title="$heading ?? ''" :subtitle="$subheading ?? ''" />

        <x-mary-card class="mt-5 w-full max-w-lg bg-base-100 border border-base-200">
            {{ $slot }}
        </x-mary-card>
    </div>
</div>
