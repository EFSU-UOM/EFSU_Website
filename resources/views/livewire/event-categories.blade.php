<?php

use function Livewire\Volt\{state};

?>

<section class="bg-base-200 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-base-content mb-4">Event Categories</h2>
            <p class="text-base-content/70">Explore different types of events we organize throughout the year.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-mary-icon name="o-academic-cap" class="w-8 h-8 text-primary" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Academic</h3>
                    <p class="text-base-content/70 text-sm">Conferences, seminars, and educational workshops</p>
                </div>
            </x-mary-card>

            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-success/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-mary-icon name="o-cpu-chip" class="w-8 h-8 text-success" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Workshops</h3>
                    <p class="text-base-content/70 text-sm">Hands-on training and skill development sessions</p>
                </div>
            </x-mary-card>

            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-mary-icon name="o-users" class="w-8 h-8 text-accent" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Social</h3>
                    <p class="text-base-content/70 text-sm">Networking events, celebrations, and community gatherings</p>
                </div>
            </x-mary-card>

            <x-mary-card class="shadow-sm hover:shadow-md transition-shadow bg-base-100">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-warning/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-mary-icon name="o-clipboard-document-list" class="w-8 h-8 text-warning" />
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Meetings</h3>
                    <p class="text-base-content/70 text-sm">Union meetings, committee sessions, and planning events</p>
                </div>
            </x-mary-card>
        </div>
    </div>
</section>