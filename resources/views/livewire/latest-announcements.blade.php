<?php

use function Livewire\Volt\{state};

?>

<section class="bg-base-100 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-mary-header title="Latest Announcements" subtitle="Stay informed with the latest updates from EFSU"
            separator>
            <x-slot:actions>
                <x-mary-button link="{{ route('news') }}" variant="link" color="primary" size="sm">
                    View All →
                </x-mary-button>
            </x-slot:actions>
        </x-mary-header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sample Announcement Cards -->
            <x-mary-card class="border border-primary/20 bg-primary/5">
                <div class="flex items-start justify-between mb-3">
                    <x-mary-badge value="Urgent" color="primary" />
                    <span class="text-sm text-base-content/60">2 hours ago</span>
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Registration Deadline Extended</h3>
                <p class="text-base-content/70 mb-4">The registration deadline for the upcoming Tech Symposium has
                    been extended to next Friday.</p>
                <x-mary-button link="#" variant="link" color="primary" size="sm">
                    Read More →
                </x-mary-button>
            </x-mary-card>

            <x-mary-card>
                <div class="flex items-start justify-between mb-3">
                    <x-mary-badge value="Event" color="primary" />
                    <span class="text-sm text-base-content/60">1 day ago</span>
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">Annual Career Fair 2024</h3>
                <p class="text-base-content/70 mb-4">Join us for the biggest career fair of the year with 50+
                    companies participating.</p>
                <x-mary-button link="#" variant="link" color="primary" size="sm">
                    Read More →
                </x-mary-button>
            </x-mary-card>

            <x-mary-card>
                <div class="flex items-start justify-between mb-3">
                    <x-mary-badge value="Academic" color="primary" />
                    <span class="text-sm text-base-content/60">3 days ago</span>
                </div>
                <h3 class="text-lg font-semibold text-base-content mb-2">New Academic Calendar Released</h3>
                <p class="text-base-content/70 mb-4">The academic calendar for the next semester has been
                    published. Check important dates.</p>
                <x-mary-button link="#" variant="link" color="primary" size="sm">
                    Read More →
                </x-mary-button>
            </x-mary-card>
        </div>
    </div>
</section>