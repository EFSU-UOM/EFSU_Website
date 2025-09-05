<?php

use App\Models\Announcement;
use function Livewire\Volt\{computed};

$announcements = computed(function() {
    return Announcement::where('is_active', true)
        ->where(function($query) {
            $query->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
        })
        ->latest()
        ->limit(3)
        ->get();
});

$getBadgeColor = function($type) {
    return match($type) {
        'urgent' => 'error',
        'academic' => 'info',
        'general' => 'primary',
        default => 'primary'
    };
};


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
            @foreach($this->announcements as $announcement)
                <x-mary-card class="{{ $announcement->is_featured ? 'border border-secondary/20 bg-secondary/5' : '' }}">
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="{{ ucfirst($announcement->type) }}" class="badge-{{ $this->getBadgeColor($announcement->type) }}" />
                        <span class="text-sm text-base-content/60">{{ $announcement->getTimeAgo() }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">{{ $announcement->title }}</h3>
                    <div class="text-base-content/70 mb-4 [&_a]:text-primary [&_a]:underline">
                        {!! $announcement->content !!}
                    </div>
                </x-mary-card>
            @endforeach
        </div>
    </div>
</section>