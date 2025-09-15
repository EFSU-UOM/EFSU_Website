<?php

use App\Models\NewsArticle;
use function Livewire\Volt\{computed};

$news = computed(function() {
    return NewsArticle::where('is_published', true)
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->limit(3)
        ->get();
});

$getBadgeColor = function($category) {
    return match($category) {
        'academic' => 'info',
        'achievements' => 'success',
        'events' => 'warning',
        'general' => 'primary',
        default => 'primary'
    };
};


?>

<section class="bg-base-100 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-mary-header title="Latest News" subtitle="Stay updated with the latest news from EFSU"
            separator>
            <x-slot:actions>
                <x-mary-button link="{{ route('news') }}" variant="link" color="primary" size="sm">
                    View All →
                </x-mary-button>
            </x-slot:actions>
        </x-mary-header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($this->news as $article)
                <x-mary-card class="{{ $article->is_featured ? 'border border-secondary/20 bg-secondary/5' : '' }}">
                    @if($article->image_url)
                        <div class="aspect-square w-full mb-4 overflow-hidden rounded-lg bg-base-200">
                            <img src="{{ $article->image_url }}" alt="{{ $article->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="flex items-start justify-between mb-3">
                        <x-mary-badge value="{{ ucfirst($article->category) }}" class="badge-{{ $this->getBadgeColor($article->category) }}" />
                        <span class="text-sm text-base-content/60">{{ $article->getTimeAgo() }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">{{ $article->title }}</h3>
                    <div class="text-base-content/70 mb-4 [&_a]:text-primary [&_a]:underline">
                        {{ $article->excerpt }}
                    </div>
                </x-mary-card>
            @endforeach
        </div>
    </div>
</section>