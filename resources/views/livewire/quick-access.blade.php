<?php

use function Livewire\Volt\{state};

?>

<section class="bg-base-200 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-mary-header title="Quick Access"
            subtitle="Find what you need quickly with easy access to our most popular services and resources."
            class="text-center mb-12" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Events Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-calendar" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Events & Calendar</h3>
                <p class="text-base-content/70 mb-4">View upcoming events, workshops, and important dates.</p>
                <x-mary-button link="{{ route('events') }}" variant="link" color="primary" size="sm">
                    View Events →
                </x-mary-button>
            </x-mary-card>

            <!-- News Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-newspaper" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Latest News</h3>
                <p class="text-base-content/70 mb-4">Stay updated with faculty news and announcements.</p>
                <x-mary-button link="{{ route('news') }}" variant="link" color="success" size="sm">
                    Read News →
                </x-mary-button>
            </x-mary-card>

            <!-- Forum Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-chat-bubble-left-right" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Discussion Forum</h3>
                <p class="text-base-content/70 mb-4">Connect with peers and discuss academic topics.</p>
                <x-mary-button link="{{ route('forum') }}" variant="link" color="secondary" size="sm">
                    Join Discussion →
                </x-mary-button>
            </x-mary-card>






            <!-- Resources Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-book-open" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Student Resources</h3>
                <p class="text-base-content/70 mb-4">Access study materials, guides, and useful links.</p>
                <x-mary-button link="{{ route('resources') }}" variant="link" color="warning" size="sm">
                    Browse Resources →
                </x-mary-button>
            </x-mary-card>
        </div>
    </div>
</section>