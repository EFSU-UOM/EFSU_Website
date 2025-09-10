<?php

use App\Models\NewsArticle;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    // Form fields
    public $title = '';
    public $excerpt = '';
    public $content = '';
    public $category = '';
    public $image = null;
    public $published_at = '';
    public $is_published = true;
    public $is_featured = false;

    public function mount()
    {
        //
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category,
            'published_at' => $this->published_at ?: now(),
            'is_published' => $this->is_published,
            'is_featured' => $this->is_featured,
        ];

        if ($this->image) {
            $data['image_url'] = $this->image->store('news-articles', 'public');
        }

        NewsArticle::create($data);

        session()->flash('success', 'News article created successfully.');
        return redirect()->route('dashboard.news-articles');
    }

    public function cancel()
    {
        return redirect()->route('dashboard.news-articles');
    }
}; ?>


<div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Create New Article</h1>
            <p class="text-base-content/70 mt-1">Create a new news article for the portal</p>
        </div>
        <x-mary-button icon="o-arrow-left" class="btn-ghost" wire:click="cancel">
            Back to Articles
        </x-mary-button>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <x-mary-alert title="Success!" description="{{ session('success') }}" icon="o-check-circle"
            class="alert-success" />
    @endif

    <!-- Article Creation Form -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="space-y-4">
                        <x-mary-input wire:model="title" label="Article Title" required
                            placeholder="Enter the article title" />

                        <x-mary-input wire:model="category" label="Category" required
                            placeholder="e.g., News, Events, Announcements" />

                        <x-mary-textarea wire:model="excerpt" label="Article Excerpt" rows="3" required
                            placeholder="Brief summary of the article..." />

                        <div>
                            <x-mary-markdown wire:model="content" label="Article Content" required />
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Publication Settings -->
                    <div class="card bg-base-200 shadow">
                        <div class="card-body">
                            <h3 class="card-title text-lg">Publication Settings</h3>
                            <div class="space-y-4">
                                <x-mary-datetime wire:model="published_at" label="Publish Date (optional)" />
                                <div class="flex flex-col gap-2">
                                    <x-mary-checkbox wire:model="is_published" label="Published" />
                                    <x-mary-checkbox wire:model="is_featured" label="Featured Article" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card bg-base-200 shadow">
                        <div class="card-body">
                            <h3 class="card-title text-lg">Featured Image</h3>
                            <x-mary-file wire:model="image" label="Upload Image" accept="image/*" crop-after-change>
                                <img src="{{ $image ? $image->temporaryUrl() : '/placeholder.avif' }}" alt="Preview"
                                    class="w-full h-48 object-cover rounded-lg" />
                            </x-mary-file>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card bg-base-200 shadow">
                        <div class="card-body">
                            <h3 class="card-title text-lg">Actions</h3>
                            <div class="flex flex-col gap-2">
                                <x-mary-button wire:click="store" class="btn-primary" icon="o-check">
                                    Create Article
                                </x-mary-button>
                                <x-mary-button wire:click="cancel" class="btn-ghost" icon="o-x-mark">
                                    Cancel
                                </x-mary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
