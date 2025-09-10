<?php

use App\Models\NewsArticle;
use Livewire\WithPagination;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteId = null;

    public function mount()
    {
        //
    }

    public function getNewsArticlesProperty()
    {
        return NewsArticle::latest()->paginate(10);
    }





    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $article = NewsArticle::findOrFail($this->deleteId);

        if ($article->image_url) {
            Storage::disk('public')->delete($article->image_url);
        }

        $article->delete();

        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'News article deleted successfully.');
    }

}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-base-content">News Articles</h1>
                <p class="text-base-content/70 mt-1">Manage news articles for the portal</p>
            </div>
            <x-mary-button icon="o-plus" class="btn-primary" onclick="window.location.href='{{ route('dashboard.news-articles.create') }}'">
                New Article
            </x-mary-button>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <x-mary-alert title="Success!" description="{{ session('success') }}" icon="o-check-circle"
                class="alert-success" />
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <x-mary-icon name="o-newspaper" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Total</div>
                    <div class="stat-value text-primary">{{ $this->newsArticles->total() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <x-mary-icon name="o-check-circle" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Published</div>
                    <div class="stat-value text-success">{{ $this->newsArticles->where('is_published', true)->count() }}
                    </div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <x-mary-icon name="o-star" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Featured</div>
                    <div class="stat-value text-warning">{{ $this->newsArticles->where('is_featured', true)->count() }}
                    </div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-info">
                        <x-mary-icon name="o-eye-slash" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Draft</div>
                    <div class="stat-value text-info">{{ $this->newsArticles->where('is_published', false)->count() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- News Articles Table -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <x-mary-table :headers="[
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'category', 'label' => 'Category'],
                    ['key' => 'is_published', 'label' => 'Status'],
                    ['key' => 'is_featured', 'label' => 'Featured'],
                    ['key' => 'published_at', 'label' => 'Published'],
                    ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
                ]" :rows="$this->newsArticles" with-pagination>

                    @scope('cell_title', $article)
                        <div>
                            <div class="font-semibold">{{ $article->title }}</div>
                            <div class="text-sm opacity-70 truncate max-w-xs">{{ Str::limit($article->excerpt, 60) }}</div>
                        </div>
                    @endscope

                    @scope('cell_category', $article)
                        <x-mary-badge :value="$article->category" class="badge-ghost" />
                    @endscope

                    @scope('cell_is_published', $article)
                        <x-mary-badge :value="$article->is_published ? 'Published' : 'Draft'"
                            class="{{ $article->is_published ? 'badge-success' : 'badge-warning' }}" />
                    @endscope

                    @scope('cell_is_featured', $article)
                        @if ($article->is_featured)
                            <x-mary-icon name="o-star" class="w-5 h-5 text-warning" />
                        @endif
                    @endscope

                    @scope('cell_published_at', $article)
                        @if ($article->published_at)
                            <span class="text-base-content">
                                {{ $article->published_at->format('M j, Y') }}
                            </span>
                        @else
                            <span class="text-base-content/50">Not published</span>
                        @endif
                    @endscope

                    @scope('cell_actions', $article)
                        <div class="flex gap-2">
                            <x-mary-button icon="o-pencil" size="xs" class="btn-ghost"
                                onclick="window.location.href='{{ route('dashboard.news-articles.edit', $article) }}'" />
                            <x-mary-button icon="o-trash" size="xs" class="btn-ghost text-error"
                                wire:click="confirmDelete({{ $article->id }})" />
                        </div>
                    @endscope
                </x-mary-table>
            </div>
        </div>
    </div>



    <!-- Delete Confirmation Modal -->
    <x-mary-modal wire:model="showDeleteModal" title="Delete News Article" class="backdrop-blur">
        <p>Are you sure you want to delete this news article? This action cannot be undone.</p>
        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="$set('showDeleteModal', false)" />
            <x-mary-button label="Delete" wire:click="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>
