<?php

use App\Models\ForumPost;
use App\Models\ForumVote;
use App\ForumCategory;
use function Livewire\Volt\{computed, state};

state([
    'selectedCategory' => 'all',
    'timeFilter' => 'all',
    'sortBy' => 'new',
    'search' => '',
])->url(history: true);

state([
    'advancedSearch' => false,
    'showSearch' => false,
    'perPage' => 20,
    'loadedCount' => 20,
]);

$filters = computed(function () {
    return [
        'category' => in_array($this->selectedCategory, array_column(ForumCategory::cases(), 'value'), true) ? $this->selectedCategory : 'all',
        'time' => in_array($this->timeFilter, ['all', 'today', 'week', 'month'], true) ? $this->timeFilter : 'all',
        'sort' => in_array($this->sortBy, ['new', 'score'], true) ? $this->sortBy : 'new',
    ];
});

$posts = computed(function () {
    $filters = $this->filters;
    $term = trim($this->search);

    $query = ForumPost::with(['user'])
        ->withCount('comments');
    
    // Apply category filter
    if ($filters['category'] !== 'all') {
        $query->where('category', $filters['category']);
    }
    
    // Apply search filter
    if ($term !== '') {
        $like = '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $term) . '%';
        if ($this->advancedSearch) {
            $query->where(function ($q) use ($like) {
                $q->whereRaw("title LIKE ? ESCAPE '!'", [$like])
                  ->orWhereRaw("content LIKE ? ESCAPE '!'", [$like]);
            });
        } else {
            $query->whereRaw("title LIKE ? ESCAPE '!'", [$like]);
        }
    }
    
    // Apply time filter
    if ($filters['time'] !== 'all') {
        $now = now();
        switch ($filters['time']) {
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
    if ($filters['sort'] === 'new') {
        $query->orderBy('created_at', 'desc');
    } else if ($filters['sort'] === 'score') {
        $query->orderBy('score', 'desc')->orderBy('created_at', 'desc');
    }
    $query->orderBy('id', 'desc');
    
    return $query->take($this->loadedCount)->get();
});

$userVotes = computed(function () {
    if (!auth()->check()) {
        return collect();
    }

    return ForumVote::where('user_id', auth()->id())
        ->where('votable_type', ForumPost::class)
        ->whereIn('votable_id', $this->posts->pluck('id'))
        ->get()
        ->pluck('is_upvote', 'votable_id');
});

$totalPosts = computed(function () {
    $filters = $this->filters;
    $term = trim($this->search);

    $query = ForumPost::query();
    
    // Apply category filter
    if ($filters['category'] !== 'all') {
        $query->where('category', $filters['category']);
    }
    
    // Apply search filter
    if ($term !== '') {
        $like = '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $term) . '%';
        if ($this->advancedSearch) {
            $query->where(function ($q) use ($like) {
                $q->whereRaw("title LIKE ? ESCAPE '!'", [$like])
                  ->orWhereRaw("content LIKE ? ESCAPE '!'", [$like]);
            });
        } else {
            $query->whereRaw("title LIKE ? ESCAPE '!'", [$like]);
        }
    }
    
    // Apply time filter
    if ($filters['time'] !== 'all') {
        $now = now();
        switch ($filters['time']) {
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

$clearFilters = function () {
    $this->search = '';
    $this->selectedCategory = 'all';
    $this->timeFilter = 'all';
    $this->sortBy = 'new';
    $this->loadedCount = $this->perPage;
};

$upvote = function ($postId) {
    if (!auth()->check()) {
        return $this->redirect(route('login'));
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        session()->flash('error', 'Please verify your email address to vote on posts.');
        return;
    }
    if (auth()->user()->isBanned()) {
        session()->flash('error', 'You are banned and cannot vote on posts.');
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
        return $this->redirect(route('login'));
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        session()->flash('error', 'Please verify your email address to vote on posts.');
        return;
    }
    if (auth()->user()->isBanned()) {
        session()->flash('error', 'You are banned and cannot vote on posts.');
        return;
    }
    
    $post = ForumPost::find($postId);
    if ($post) {
        $post->downvote(auth()->user());
        $this->dispatch('post-voted');
    }
};

$deletePost = function ($postId) {
    if (!auth()->check()) {
        return $this->redirect(route('login'));
    }

    $post = ForumPost::find($postId);
    if (!$post) {
        session()->flash('error', 'Post not found.');
        return;
    }

    // Check if user is admin or post owner
    if (!auth()->user()->isAdmin() && $post->user_id !== auth()->id()) {
        session()->flash('error', 'You can only delete your own posts.');
        return;
    }
    
    $post->delete();
    $this->dispatch('post-deleted');
};
?>

<section class="bg-base-100 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (session('error'))
            <x-mary-alert title="Error!" description="{{ session('error') }}" icon="o-x-circle" class="alert-error mb-6" />
        @endif

        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-base-content">Recent Discussions</h2>
                <div class="flex flex-wrap gap-4">
                    <x-mary-select
                        wire:model.live="selectedCategory"
                        class="w-full sm:w-56"
                        placeholder="All Categories" 
                        :options="$this->categories"
                        option-value="value"
                        option-label="name" />
                    <x-mary-select 
                        wire:model.live="timeFilter"
                        class="w-full sm:w-48"
                        placeholder="Time Period" 
                        :options="$this->timeOptions"
                        option-value="value"
                        option-label="name" />
                    <x-mary-select 
                        wire:model.live="sortBy"
                        class="w-full sm:w-48"
                        placeholder="Sort By" 
                        :options="$this->sortOptions"
                        option-value="value"
                        option-label="name" />
                    <button
                        wire:click="toggleSearch"
                        aria-label="Toggle search"
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
                    <x-mary-checkbox
                        label="Search content"
                        wire:model.live="advancedSearch"
                        class="checkbox-sm" />
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
                                    aria-label="Upvote post"
                                    class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-success/10 transition-colors
                                           {{ auth()->check() && $this->userVotes->get($post->id) === true ? 'bg-success/20 text-success' : 'text-base-content/60' }}">
                                    <x-mary-icon name="o-chevron-up" class="w-5 h-5" />
                                </button>
                                <span class="text-sm font-semibold text-base-content">{{ $post->score }}</span>
                                <button
                                    wire:click="downvote({{ $post->id }})"
                                    aria-label="Downvote post"
                                    class="flex items-center justify-center w-8 h-8 rounded-full hover:bg-error/10 transition-colors
                                           {{ auth()->check() && $this->userVotes->get($post->id) === false ? 'bg-error/20 text-error' : 'text-base-content/60' }}">
                                    <x-mary-icon name="o-chevron-down" class="w-5 h-5" />
                                </button>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        @if($post->is_pinned)
                                            <x-mary-badge value="Pinned" class="badge-warning mr-2" />
                                        @endif
                                        <x-mary-badge 
                                            value="{{ $post->category->label() }}" 
                                            class="badge-{{ $post->category->color() }} mr-2" />
                                        <a href="{{ route('forum.post', $post) }}" class="text-lg font-semibold text-base-content hover:text-primary cursor-pointer">
                                            {{ $post->title }}
                                        </a>
                                    </div>
                                    @if(auth()->check() && (auth()->user()->isAdmin() || $post->user_id === auth()->id()))
                                        <button 
                                            wire:click="deletePost({{ $post->id }})"
                                            wire:confirm="Are you sure you want to delete this post? This action cannot be undone."
                                            class="flex items-center space-x-1 px-2 py-1 rounded-md text-xs transition-colors bg-error/20 text-error hover:bg-error/30">
                                            <x-mary-icon name="o-trash" class="w-3 h-3" />
                                            <span>Delete</span>
                                        </button>
                                    @endif
                                </div>
                                <p class="text-base-content/70 mb-3">{{ Str::limit($post->content, 1000) }}</p>
                                <div class="flex items-center text-sm text-base-content/60 space-x-4">
                                    <span>By <strong>{{ $post->user->name ?? 'Anonymous' }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                    <span>•</span>
                                    <span>{{ $post->comments_count }} {{ Str::plural('reply', $post->comments_count) }}</span>
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
                        @if($search !== '' || $selectedCategory !== 'all' || $timeFilter !== 'all' || $sortBy !== 'new')
                            <h3 class="text-lg font-semibold text-base-content/60 mb-2">No discussions match your filters</h3>
                            <x-mary-button wire:click="clearFilters" class="btn-outline btn-sm mt-2" label="Clear filters" />
                        @else
                            <p class="text-base-content/40">Be the first to start a discussion!</p>
                        @endif
                    </div>
                @endforelse
            </div>
        </x-mary-card>

        <!-- Load More Button -->
        @if($this->hasMore)
            <div class="flex justify-center mt-8">
                <x-mary-button wire:click="loadMore" class="btn-outline" spinner="loadMore" wire:loading.attr="disabled" wire:target="loadMore">
                    Load More Posts
                </x-mary-button>
            </div>
        @endif
    </div>
</section>