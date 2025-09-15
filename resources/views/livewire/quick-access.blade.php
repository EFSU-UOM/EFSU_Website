<?php

use function Livewire\Volt\{state};

?>

<section class="bg-base-200 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-mary-header title="Quick Access"
            subtitle="Find what you need quickly with easy access to our most popular services and resources."
            class="text-center mb-12" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Forum Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-chat-bubble-left-right" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Discussion Forum</h3>
                <p class="text-base-content/70 mb-4">Connect with peers and discuss academic topics.</p>
                <x-mary-button link="{{ route('forum') }}" variant="link" color="primary" size="sm">
                    Join Discussion →
                </x-mary-button>
            </x-mary-card>

            <!-- Complaints Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-exclamation-triangle" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Complaints</h3>
                <p class="text-base-content/70 mb-4">Submit and track complaints or feedback.</p>
                <x-mary-button link="{{ route('complaints') }}" variant="link" color="warning" size="sm">
                    Submit Complaint →
                </x-mary-button>
            </x-mary-card>

            <!-- Lost & Found Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-magnifying-glass" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Lost & Found</h3>
                <p class="text-base-content/70 mb-4">Report lost items or find items that have been found.</p>
                <x-mary-button link="{{ route('lost-and-found') }}" variant="link" color="secondary" size="sm">
                    Browse Items →
                </x-mary-button>
            </x-mary-card>

            <!-- Boarding Places Card -->
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <x-mary-icon name="o-home" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Boarding Places</h3>
                <p class="text-base-content/70 mb-4">Find accommodation and boarding options near campus.</p>
                <x-mary-button link="{{ route('boarding.places') }}" variant="link" color="success" size="sm">
                    Find Accommodation →
                </x-mary-button>
            </x-mary-card>
        </div>
    </div>
</section>