<?php

use App\Models\NewsArticle;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $selectedCategory = '';

    public function getArticlesProperty()
    {
        $query = NewsArticle::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');

        if ($this->selectedCategory) {
            $query->where('category', $this->selectedCategory);
        }

        return $query->paginate(9);
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function getBadgeColor($category)
    {
        return match($category) {
            'academic' => 'primary',
            'events' => 'success',
            'achievements' => 'warning',
            'general' => 'neutral',
            default => 'neutral'
        };
    }
}; ?>

<section class="bg-base-200 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-base-content">Latest Articles</h2>
            <div class="flex space-x-4">
                <x-mary-select
                    wire:model.live="selectedCategory"
                    class="w-48"
                    :options="[
                        ['name' => 'All Categories', 'id' => ''],
                        ['name' => 'Academic', 'id' => 'academic'],
                        ['name' => 'Events', 'id' => 'events'],
                        ['name' => 'Achievements', 'id' => 'achievements'],
                        ['name' => 'General', 'id' => 'general'],
                    ]"
                />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($this->articles as $article)
                <x-mary-card class="bg-base-100 border border-base-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <x-slot:figure>
                        <img src="{{ Storage::url($article->image_url) }}"
                             alt="{{ $article->title }}" class="w-full aspect-square object-cover">
                    </x-slot:figure>
                        <div class="flex items-center mb-3">
                            <x-mary-badge value="{{ ucfirst($article->category) }}" color="{{ $this->getBadgeColor($article->category) }}" class="mr-3" />
                            <span class="text-sm text-base-content/60">{{ $article->published_at->format('M j, Y') }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">{{ $article->title }}</h3>
                        <p class="text-base-content/70 mb-4">{!! $article->excerpt !!}</p>
                        <x-mary-button link="{{ route('article', $article) }}" label="Read More" class="btn-link btn-sm" right-icon="o-arrow-right" />
                </x-mary-card>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-base-content/60">No articles found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $this->articles->links() }}
        </div>
    </div>
</section>