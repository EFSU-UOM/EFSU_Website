<?php

use App\Models\ForumPost;
use App\ForumCategory;
use function Livewire\Volt\{computed,state};

state([
    'showNewPostModal' => false,
    'newPostTitle' => '',
    'newPostContent' => '',
    'newPostCategory' => 'all',
]);

$categories = computed(function () {
    return collect(ForumCategory::cases())->map(function ($category) {
        $topicsCount = ForumPost::where('category', $category)->count();

        return [
            'category' => $category,
            'label' => $category->label(),
            'description' => $category->description(),
            'icon' => $category->icon(),
            'background' => match ($category->color()) {
                'primary' => 'bg-primary/10',
                'success' => 'bg-success/10',
                'secondary' => 'bg-secondary/10',
                'warning' => 'bg-warning/10',
            },
            'text' => match ($category->color()) {
                'primary' => 'text-primary',
                'success' => 'text-success',
                'secondary' => 'text-secondary',
                'warning' => 'text-warning',
            },
            'posts_count' => $topicsCount,
        ];
    });
});

$openNewPostModal = function () {
    if (!auth()->check()) {
        return $this->redirect(route('login'));
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        session()->flash('error', 'Please verify your email address to create posts.');
        return;
    }
    if (auth()->user()->isBanned()) {
        session()->flash('error', 'You are banned and cannot create forum posts.');
        return;
    }

    $this->showNewPostModal = true;
    $this->newPostTitle = '';
    $this->newPostContent = '';
    $this->newPostCategory = ForumCategory::GENERAL->value;
};

$closeNewPostModal = function () {
    $this->showNewPostModal = false;
    $this->newPostTitle = '';
    $this->newPostContent = '';
    $this->newPostCategory = '';
};

$createPost = function () {
    if (!auth()->check()) {
        return $this->redirect(route('login'));
    }
    if (!auth()->user()->hasVerifiedEmail()) {
        session()->flash('error', 'Please verify your email address to create posts.');
        return;
    }
    if (auth()->user()->isBanned()) {
        session()->flash('error', 'You are banned and cannot create forum posts.');
        return;
    }

    $this->validate(
        [
            'newPostTitle' => 'required|min:3|max:255',
            'newPostContent' => 'required|min:10|max:5000',
            'newPostCategory' => 'required|in:' . implode(',', array_column(ForumCategory::cases(), 'value')),
        ],
        [
            'newPostTitle.required' => 'Title is required',
            'newPostTitle.min' => 'Title must be at least 3 characters',
            'newPostTitle.max' => 'Title must not exceed 255 characters',
            'newPostContent.required' => 'Content is required',
            'newPostContent.min' => 'Content must be at least 10 characters',
            'newPostContent.max' => 'Content must not exceed 5000 characters',
            'newPostCategory.required' => 'Category is required',
            'newPostCategory.in' => 'Invalid category selected',
        ],
    );

    $post = ForumPost::create([
        'title' => $this->newPostTitle,
        'content' => $this->newPostContent,
        'category' => ForumCategory::from($this->newPostCategory),
        'user_id' => auth()->id(),
        'upvotes' => 0,
        'downvotes' => 0,
        'score' => 0,
    ]);

    return redirect()->route('forum.post', $post);
};

?>

<section class="bg-base-200 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (session('error'))
            <x-mary-alert title="Error!" description="{{ session('error') }}" icon="o-x-circle" class="alert-error mb-6" />
        @endif

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-base-content">Forum Categories</h2>
            <x-mary-button wire:click="openNewPostModal" class="btn-primary" icon="o-plus" label="New Discussion" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @foreach ($this->categories as $categoryData)
                <a href="{{ route('forum', ['selectedCategory' => $categoryData['category']->value]) }}" class="block">
                    <x-mary-card class="bg-base-100 hover:shadow-lg transition-shadow h-full">
                        <div
                            class="w-12 h-12 {{ $categoryData['background'] }} rounded-lg flex items-center justify-center mb-4">
                            <x-mary-icon name="{{ $categoryData['icon'] }}"
                                class="w-6 h-6 {{ $categoryData['text'] }}" />
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">{{ $categoryData['label'] }}</h3>
                        <p class="text-base-content/70 text-sm mb-4">{{ $categoryData['description'] }}</p>
                        <div class="flex items-center justify-end text-sm text-base-content/60">
                            <span>{{ $categoryData['posts_count'] }} {{ Str::plural('post', $categoryData['posts_count']) }}</span>
                        </div>
                    </x-mary-card>
                </a>
            @endforeach
        </div>
    </div>
    <!-- New Post Modal -->
    <x-mary-modal wire:model="showNewPostModal" class="backdrop-blur">
        <x-mary-header title="Create New Discussion" subtitle="Start a new topic in the forum" />

        <div class="py-4">
            <x-mary-form wire:submit="createPost">
                <x-mary-input label="Title" wire:model="newPostTitle" placeholder="Enter discussion title..."
                    hint="Choose a clear, descriptive title" required />

                <x-mary-select label="Category" wire:model="newPostCategory" :options="collect(App\ForumCategory::cases())->map(
                    fn($c) => ['value' => $c->value, 'name' => $c->label()],
                )" option-value="value"
                    option-label="name" placeholder="Select a category" required />

                <x-mary-textarea label="Content" wire:model="newPostContent" placeholder="Write your post content..."
                    hint="Provide details about your topic or question" rows="6" required />

                <x-slot:actions>
                    <x-mary-button label="Cancel" wire:click="closeNewPostModal" />
                    <x-mary-button label="Create Discussion" class="btn-primary" type="submit" spinner="createPost" />
                </x-slot:actions>
            </x-mary-form>
        </div>
    </x-mary-modal>
</section>
