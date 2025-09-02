<?php

use App\Models\GalleryItem;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination, WithFileUploads;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $deleteId = null;
    public $editId = null;
    
    // Form fields
    public $title = '';
    public $description = '';
    public $type = 'image';
    public $file = null;
    public $category = '';
    public $link = '';
    public $currentFilePath = null;

    public function mount()
    {
        //
    }

    public function getGalleryItemsProperty()
    {
        return GalleryItem::with('user')
            ->latest()
            ->paginate(10);
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function openEditModal($id)
    {
        $item = GalleryItem::findOrFail($id);
        $this->editId = $id;
        $this->title = $item->title;
        $this->description = $item->description;
        $this->type = $item->type;
        $this->category = $item->category;
        $this->link = $item->link;
        $this->currentFilePath = $item->file_path;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editId = null;
        $this->resetForm();
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,document',
            'file' => 'required|file|max:10240',
            'category' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'category' => $this->category,
            'link' => $this->link,
            'user_id' => auth()->id(),
        ];

        if ($this->file) {
            $data['file_path'] = '/storage/' . $this->file->store('gallery', 'public');
        }

        GalleryItem::create($data);

        $this->closeCreateModal();
        session()->flash('success', 'Gallery item created successfully.');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,document',
            'file' => 'nullable|file|max:10240',
            'category' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);

        $item = GalleryItem::findOrFail($this->editId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'category' => $this->category,
            'link' => $this->link,
        ];

        if ($this->file) {
            if ($item->file_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $item->file_path));
            }
            $data['file_path'] = '/storage/' . $this->file->store('gallery', 'public');
        }

        $item->update($data);

        $this->closeEditModal();
        session()->flash('success', 'Gallery item updated successfully.');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $item = GalleryItem::findOrFail($this->deleteId);
        
        if ($item->file_path) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $item->file_path));
        }

        $item->delete();
        
        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'Gallery item deleted successfully.');
    }

    private function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->type = 'image';
        $this->file = null;
        $this->category = '';
        $this->link = '';
        $this->currentFilePath = null;
    }
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-base-content">Gallery Items</h1>
                <p class="text-base-content/70 mt-1">Manage gallery items for the portal</p>
            </div>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="openCreateModal">
                New Gallery Item
            </x-mary-button>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <x-mary-alert title="Success!" description="{{ session('success') }}" icon="o-check-circle" class="alert-success" />
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <x-mary-icon name="o-photo" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Total</div>
                    <div class="stat-value text-primary">{{ $this->galleryItems->total() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <x-mary-icon name="o-photo" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Images</div>
                    <div class="stat-value text-success">{{ $this->galleryItems->where('type', 'image')->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <x-mary-icon name="o-video-camera" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Videos</div>
                    <div class="stat-value text-warning">{{ $this->galleryItems->where('type', 'video')->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-info">
                        <x-mary-icon name="o-document" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Documents</div>
                    <div class="stat-value text-info">{{ $this->galleryItems->where('type', 'document')->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Gallery Items Table -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <x-mary-table :headers="[
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'type', 'label' => 'Type'],
                    ['key' => 'category', 'label' => 'Category'],
                    ['key' => 'link', 'label' => 'Link'],
                    ['key' => 'actions', 'label' => 'Actions', 'sortable' => false]
                ]" :rows="$this->galleryItems" with-pagination>
                    
                    @scope('cell_title', $item)
                        <div>
                            <div class="font-semibold">{{ $item->title }}</div>
                            @if($item->description)
                                <div class="text-sm opacity-70 truncate max-w-xs">{{ Str::limit($item->description, 60) }}</div>
                            @endif
                        </div>
                    @endscope

                    @scope('cell_type', $item)
                        <x-mary-badge 
                            :value="$item->type" 
                            class="badge-ghost"
                        />
                    @endscope

                    @scope('cell_category', $item)
                        <x-mary-badge 
                            :value="$item->category" 
                            class="badge-ghost"
                        />
                    @endscope

                    @scope('cell_link', $item)
                        @if($item->link)
                            <a href="{{ $item->link }}" target="_blank" class="text-primary hover:underline">
                                <x-mary-icon name="o-link" class="w-4 h-4" />
                            </a>
                        @endif
                    @endscope

                    @scope('cell_actions', $item)
                        <div class="flex gap-2">
                            <x-mary-button 
                                icon="o-pencil" 
                                size="xs" 
                                class="btn-ghost"
                                wire:click="openEditModal({{ $item->id }})"
                            />
                            <x-mary-button 
                                icon="o-trash" 
                                size="xs" 
                                class="btn-ghost text-error"
                                wire:click="confirmDelete({{ $item->id }})"
                            />
                        </div>
                    @endscope
                </x-mary-table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <x-mary-modal wire:model="showCreateModal" title="Create Gallery Item" class="backdrop-blur">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-mary-input wire:model="title" label="Title" required />
                <x-mary-input wire:model="category" label="Category" required />
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="description" label="Description" rows="3" />
                </div>
                <x-mary-select wire:model="type" label="Type" :options="[
                    ['id' => 'image', 'name' => 'Image'],
                    ['id' => 'video', 'name' => 'Video'],
                    ['id' => 'document', 'name' => 'Document']
                ]" required />
                <x-mary-input wire:model="link" label="Link (optional)" type="url" />
                <div class="md:col-span-2">
                    <x-mary-file wire:model="file" label="File" required />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="closeCreateModal" />
                <x-mary-button label="Create" wire:click="store" class="btn-primary" />
            </x-slot:actions>
    </x-mary-modal>

    <!-- Edit Modal -->
    <x-mary-modal wire:model="showEditModal" title="Edit Gallery Item" class="backdrop-blur">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-mary-input wire:model="title" label="Title" required />
                <x-mary-input wire:model="category" label="Category" required />
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="description" label="Description" rows="3" />
                </div>
                <x-mary-select wire:model="type" label="Type" :options="[
                    ['id' => 'image', 'name' => 'Image'],
                    ['id' => 'video', 'name' => 'Video'],
                    ['id' => 'document', 'name' => 'Document']
                ]" required />
                <x-mary-input wire:model="link" label="Link (optional)" type="url" />
                
                @if($currentFilePath)
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Current File</span>
                        </label>
                        <div class="flex flex-col items-center gap-4 p-4 bg-base-200 rounded-lg">
                            @if($type === 'image')
                                <img src="{{ $currentFilePath }}" alt="Current image" class="w-full h-full object-cover rounded-lg">
                            @elseif($type === 'video')
                                <video class="w-20 h-20 object-cover rounded-lg" controls>
                                    <source src="{{ $currentFilePath }}" type="video/mp4">
                                </video>
                            @else
                                <div class="w-20 h-20 bg-base-300 rounded-lg flex items-center justify-center">
                                    <x-mary-icon name="o-document" class="w-8 h-8" />
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-medium">{{ basename($currentFilePath) }}</p>
                                <p class="text-xs text-base-content/70">Click below to change file</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="md:col-span-2">
                    <x-mary-file wire:model="file" label="File (optional - leave blank to keep current)" />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="closeEditModal" />
                <x-mary-button label="Update" wire:click="update" class="btn-primary" />
            </x-slot:actions>
    </x-mary-modal>

    <!-- Delete Confirmation Modal -->
    <x-mary-modal wire:model="showDeleteModal" title="Delete Gallery Item" class="backdrop-blur">
        <p>Are you sure you want to delete this gallery item? This action cannot be undone.</p>
        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="$set('showDeleteModal', false)" />
            <x-mary-button label="Delete" wire:click="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>