<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-svh antialiased bg-base-100 text-base-content">
    <div class="min-h-svh flex items-center justify-center p-6 md:p-10">
        <x-mary-card class="w-full max-w-sm">
            <div class="flex flex-col items-center gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <div class="h-16 w-16 rounded-lg overflow-hidden">
                        <img src="{{ asset('android-chrome-192x192.png') }}" alt="EFSU logo"
                            class="h-full w-full object-contain" />
                    </div>
                </a>
            </div>

            <div class="mt-6">
                {{ $slot }}
            </div>
        </x-mary-card>
    </div>
</body>


</html>
