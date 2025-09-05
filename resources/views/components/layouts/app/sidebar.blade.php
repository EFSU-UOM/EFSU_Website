<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-base-100">
        <div class="drawer lg:drawer-open">
            <input id="main-sidebar" type="checkbox" class="drawer-toggle" />
            
            <div class="drawer-content flex flex-col">
                <!-- Mobile Header -->
                <div class="navbar lg:hidden bg-base-100 border-b border-base-200">
                    <div class="navbar-start">
                        <label for="main-sidebar" class="btn btn-ghost btn-square drawer-button lg:hidden">
                            <x-mary-icon name="o-bars-3" />
                        </label>
                    </div>
                    
                    <div class="navbar-end">
                        <x-mary-dropdown align="end" no-x-anchor right>
                            <x-slot:trigger>
                                <div class="flex items-center space-x-2 p-2 rounded-lg hover:bg-base-200 cursor-pointer">
                                    <div class="w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold text-sm">
                                        {{ auth()->user()->initials() }}
                                    </div>
                                    <x-mary-icon name="o-chevron-down" class="w-4 h-4" />
                                </div>
                            </x-slot:trigger>
                            <x-mary-menu class="menu menu-md w-56 z-50">
                                <div class="px-3 py-3 border-b border-base-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold">
                                            {{ auth()->user()->initials() }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-sm">{{ auth()->user()->name }}</div>
                                            <div class="text-xs opacity-70">{{ auth()->user()->email }}</div>
                                        </div>
                                    </div>
                                </div>
                                <x-mary-menu-item link="{{ route('settings.profile') }}" wire:navigate>
                                    <x-mary-icon name="o-cog-6-tooth" class="w-5 h-5" />
                                    Settings
                                </x-mary-menu-item>
                                <x-mary-menu-separator />
                                <x-mary-menu-item>
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full text-left">
                                            <x-mary-icon name="o-arrow-right-on-rectangle" class="w-5 h-5 mr-2" />
                                            Log Out
                                        </button>
                                    </form>
                                </x-mary-menu-item>
                            </x-mary-menu>
                        </x-mary-dropdown>
                    </div>
                </div>

                <!-- Main Content -->
                <main class="flex-1 p-4">
                    {{ $slot }}
                </main>
            </div>
            
            <div class="drawer-side">
                <label for="main-sidebar" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="w-64 min-h-full bg-base-100 border-r border-base-200 flex flex-col">
                    <!-- Logo -->
                    <div class="p-4 border-b border-base-200">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2" wire:navigate>
                           <div class="h-8 w-8 rounded-lg overflow-hidden">
                                <img src="{{ asset('android-chrome-192x192.png') }}" alt="EFSU logo" class="h-full w-full object-contain" />
                            </div>
                            <span class="text-xl font-semibold">Engineering Faculty Students Union</span>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <div class="flex-1 p-4">
                        <x-mary-menu class="menu menu-vertical w-full">
                            <x-mary-menu-item link="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" wire:navigate>
                                    <x-mary-icon name="o-home" class="w-5 h-5" />
                                    {{ __('Dashboard') }}
                                </x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('dashboard.announcements') }}" :active="request()->routeIs('dashboard.announcements')" wire:navigate>
                                    <x-mary-icon name="o-megaphone" class="w-5 h-5" />
                                    {{ __('Announcements') }}
                                </x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('dashboard.merch') }}" :active="request()->routeIs('dashboard.merch')" wire:navigate>
                                    <x-mary-icon name="o-shopping-bag" class="w-5 h-5" />
                                    {{ __('Merch') }}
                                </x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('dashboard.news-articles') }}" :active="request()->routeIs('dashboard.news-articles')" wire:navigate>
                                    <x-mary-icon name="o-newspaper" class="w-5 h-5" />
                                    {{ __('News Articles') }}
                                </x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('dashboard.gallery-items') }}" :active="request()->routeIs('dashboard.gallery-items')" wire:navigate>
                                    <x-mary-icon name="o-photo" class="w-5 h-5" />
                                    {{ __('Gallery Items') }}
                                </x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('dashboard.events') }}" :active="request()->routeIs('dashboard.events')" wire:navigate>
                                    <x-mary-icon name="o-calendar" class="w-5 h-5" />
                                    {{ __('Events') }}
                                </x-mary-menu-item>
                            <x-mary-menu-item link="{{ route('dashboard.users') }}" :active="request()->routeIs('dashboard.users*')" wire:navigate>
                                    <x-mary-icon name="o-users" class="w-5 h-5" />
                                    {{ __('Users') }}
                                </x-mary-menu-item>
                        </x-mary-menu>
                    </div>

                    <!-- Desktop User Menu -->
                    <div class="p-4 border-t border-base-200 hidden lg:block">
                        <x-mary-dropdown no-x-anchor top>
                            <x-slot:trigger>
                                <div class="flex items-center space-x-2 px-3 py-2 rounded-lg border border-primary/20 bg-primary/5 hover:bg-primary/10 transition-colors cursor-pointer">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold">
                                            {{ auth()->user()->initials() }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-sm">{{ auth()->user()->name }}</div>
                                            <div class="text-xs opacity-70">{{ auth()->user()->email }}</div>
                                        </div>
                                    </div>
                                    <x-mary-icon name="o-chevron-up" class="w-4 h-4 opacity-60" />
                                </div>
                            </x-slot:trigger>
                            <x-mary-menu class="menu menu-md">
                                <x-mary-menu-item link="{{ route('settings.profile') }}">
                                    <x-mary-icon name="o-user-circle" class="me-3 w-5 h-5" />
                                    <span class="font-medium">My Profile</span>
                                </x-mary-menu-item>
                                <x-mary-menu-item class="text-error hover:bg-error/10">
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full text-left">
                                            <x-mary-icon name="o-arrow-right-on-rectangle" class="me-3 w-5 h-5" />
                                            <span class="font-medium">Logout</span>
                                        </button>
                                    </form>
                                </x-mary-menu-item>
                            </x-mary-menu>
                        </x-mary-dropdown>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
