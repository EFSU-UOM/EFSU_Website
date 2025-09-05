<?php

use App\Models\ForumPost;
use App\ForumCategory;
use function Livewire\Volt\{computed, state};

state([
    'selectedCategory' => 'all',
    'timeFilter' => 'all',
    'sortBy' => 'new',
    'search' => '',
    'advancedSearch' => false,
    'showSearch' => false,
    'perPage' => 20,
    'loadedCount' => 20,
]);

$posts = computed(function () {
    $query = ForumPost::with(['user', 'comments'])
        ->withCount('comments');
    
    // Apply category filter
    if ($this->selectedCategory !== 'all') {
        $query->where('category', $this->selectedCategory);
    }
    
    // Apply search filter
    if (!empty($this->search)) {
        if ($this->advancedSearch) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        } else {
            $query->where('title', 'like', '%' . $this->search . '%');
        }
    }
    
    // Apply time filter
    if ($this->timeFilter !== 'all') {
        $now = now();
        switch ($this->timeFilter) {
            case 'today':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'week':
                $query->where('created_at', '>=', $now->subWeek());
                break;
            case 'month':
                $query->where('created_at', '>=', $now->subMonth());
                break;
        }
    }
    
    // Apply sorting (pinned posts always come first)
    $query->orderBy('is_pinned', 'desc');
    if ($this->sortBy === 'new') {
        $query->orderBy('created_at', 'desc');
    } else if ($this->sortBy === 'score') {
        $query->orderBy('score', 'desc')->orderBy('created_at', 'desc');
    }
    
    return $query->take($this->loadedCount)->get();
});

$totalPosts = computed(function () {
    $query = ForumPost::query();
    
    // Apply category filter
    if ($this->selectedCategory !== 'all') {
        $query->where('category', $this->selectedCategory);
    }
    
    // Apply search filter
    if (!empty($this->search)) {
        if ($this->advancedSearch) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        } else {
            $query->where('title', 'like', '%' . $this->search . '%');
        }
    }
    
    // Apply time filter
    if ($this->timeFilter !== 'all') {
        $now = now();
        switch ($this->timeFilter) {
            case 'today':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'week':
                $query->where('created_at', '>=', $now->subWeek());
                break;
            case 'month':
                $query->where('created_at', '>=', $now->subMonth());
                break;
        }
    }
    
    return $query->count();
});

$loadMore = function () {
    $this->loadedCount += $this->perPage;
};

$hasMore = computed(function () {
    return $this->loadedCount < $this->totalPosts;
});

$categories = computed(function () {
    return collect(ForumCategory::cases())->map(fn($category) => [
            'value' => $category->value,
            'name' => $category->label()
        ]);
});

$timeOptions = computed(function () {
    return [
        ['value' => 'all', 'name' => 'All Time'],
        ['value' => 'today', 'name' => 'Today'],
        ['value' => 'week', 'name' => 'This Week'],
        ['value' => 'month', 'name' => 'This Month'],
    ];
});

$sortOptions = computed(function () {
    return [
        ['value' => 'new', 'name' => 'Newest'],
        ['value' => 'score', 'name' => 'Top Scored'],
    ];
});

$toggleSearch = function () {
    $this->showSearch = !$this->showSearch;
    if (!$this->showSearch) {
        $this->search = '';
        $this->advancedSearch = false;
        $this->loadedCount = $this->perPage;
    }
};

$updated = function ($property) {
    if (in_array($property, ['selectedCategory', 'timeFilter', 'sortBy', 'search', 'advancedSearch'])) {
        $this->loadedCount = $this->perPage;
    }
};

$upvote = function ($postId) {
    if (!auth()->check()) {
        $this->js('alert("Please log in to vote on posts.")');
        return;
    }
    
    $post = ForumPost::find($postId);
    if ($post) {
        $post->upvote(auth()->user());
        $this->dispatch('post-voted');
    }
};

$downvote = function ($postId) {
    if (!auth()->check()) {
        $this->js('alert("Please log in to vote on posts.")');
        return;
    }
    
    $post = ForumPost::find($postId);
    if ($post) {
        $post->downvote(auth()->user());
        $this->dispatch('post-voted');
    }
};
?>

<section class="bg-base-100 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-base-content">Recent Discussions</h2>
                <div class="flex space-x-4">
                    <x-mary-select 
                        wire:model.live="selectedCategory" 
                        class="w-56" 
                        placeholder="All Categories" 
                        :options="$this->categories"
                        option-value="value"
                        option-label="name" />
                    <x-mary-select 
                        wire:model.live="timeFilter" 
                        class="w-48" 
                        placeholder="Time Period" 
                        :options="$this->timeOptions"
                        option-value="value"
                        option-label="name" />
                    <x-mary-select 
                        wire:model.live="sortBy" 
                        class="w-48" 
                        placeholder="Sort By" 
                        :options="$this->sortOptions"
                        option-value="value"
                        option-label="name" />
                    <button 
                        wire:click="toggleSearch"
                        class="flex items-center justify-center w-10 h-10 rounded-md border border-base-300 hover:bg-base-200 transition-colors">
                        <x-mary-icon name="o-magnifying-glass" class="w-5 h-5" />
                    </button>
                </div>
            </div>
            @if($showSearch)
                <div class="flex items-center space-x-4">
                    <x-mary-input 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search forum topics..." 
                        class="flex-1" 
                        icon="o-magnifying-glass" />
                    <div class="flex items-center space-x-2">
                        <x-mary-checkbox 
                            wire:model.live="advancedSearch" 
                            class="checkbox-sm" />
                        <span class="text-sm text-base-content/70">Search content</span>
                    </div>
                </div>
            @endif
        </div>

        <x-mary-card class="bg-base-200 rounded-xl p-0 overflow-hidden">
            <div class="divide-y divide-base-300">
                @forelse($this->posts as $post)
                    <div class="p-6 hover:bg-base-200 transition-colors">
                        <div class="flex items-start justify-between">
                            <!-- Vote buttons -->
                            <div class="flex flex-col items-center mr-4 space-y-1">
                                <button 
                                    wire:click="upvote({{ $post->id }})"
                                    class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-success/10 transition-colors
                                           {{ auth()->check() && $post->getUserVote(auth()->user()) === true ? 'bg-success/20 text-success' : 'text-base-content/60' }}">
                                    <x-mary-icon name="o-chevron-up" class="w-5 h-5" />
                                </button>
                                <span class="text-sm font-semibold text-base-content">{{ $post->score }}</span>
                                <button 
                                    wire:click="downvote({{ $post->id }})"
                                    class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-error/10 transition-colors
                                           {{ auth()->check() && $post->getUserVote(auth()->user()) === false ? 'bg-error/20 text-error' : 'text-base-content/60' }}">
                                    <x-mary-icon name="o-chevron-down" class="w-5 h-5" />
                                </button>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    @if($post->is_pinned)
                                        <x-mary-badge value="Pinned" class="badge-warning mr-2" />
                                    @endif
                                    <x-mary-badge 
                                        value="{{ $post->category->label() }}" 
                                        class="badge-{{ $post->category->color() }} mr-2" />
                                    <a href="{{ route('forum.post', $post) }}" class="text-lg font-semibold text-base-content hover:text-primary cursor-pointer">
                                        {{ $post->title }}
                                    </a>
                                    @if($post->is_pinned)
                                        <x-mary-icon name="o-bookmark" class="w-4 h-4 text-warning ml-2" />
                                    @endif
                                </div>
                                <p class="text-base-content/70 mb-3">{{ Str::limit($post->content, 1000) }}</p>
                                <div class="flex items-center text-sm text-base-content/60 space-x-4">
                                    <span>By <strong>{{ $post->user->name ?? 'Anonymous' }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                    <span>•</span>
                                    <span>{{ $post->comments_count }} replies</span>
                                    <span>•</span>
                                    <span>{{ $post->totalVotes() }} votes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <x-mary-icon name="o-chat-bubble-left-ellipsis" class="w-16 h-16 text-base-content/20 mx-auto mb-4" />
                        <h3 class="text-lg font-semibold text-base-content/60 mb-2">No discussions found</h3>
                        <p class="text-base-content/40">Be the first to start a discussion!</p>
                    </div>
                @endforelse
            </div>
        </x-mary-card>

        <!-- Load More Button -->
        @if($this->hasMore)
            <div class="flex justify-center mt-8">
                <x-mary-button wire:click="loadMore" class="btn-outline">
                    Load More Posts
                </x-mary-button>
            </div>
        @endif
    </div>
</section>