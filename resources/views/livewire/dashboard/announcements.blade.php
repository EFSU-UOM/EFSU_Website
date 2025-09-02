<?php

use App\Models\Announcement;
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
    public $content = '';
    public $type = 'general';
    public $image = null;
    public $expires_at = '';
    public $is_active = true;
    public $is_featured = false;
    public $currentImageUrl = null;

    public function mount()
    {
        //
    }

    public function getAnnouncementsProperty()
    {
        return Announcement::with('user')
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
        $announcement = Announcement::findOrFail($id);
        $this->editId = $id;
        $this->title = $announcement->title;
        $this->content = $announcement->content;
        $this->type = $announcement->type;
        $this->expires_at = $announcement->expires_at ? $announcement->expires_at->format('Y-m-d\TH:i') : '';
        $this->is_active = $announcement->is_active;
        $this->is_featured = $announcement->is_featured;
        $this->currentImageUrl = $announcement->image_url;
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
            'content' => 'required|string',
            'type' => 'required|in:general,event,urgent,maintenance',
            'image' => 'nullable|image|max:2048',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'expires_at' => $this->expires_at ?: null,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'user_id' => auth()->id(),
        ];

        if ($this->image) {
            $data['image_url'] = '/storage/' . $this->image->store('announcements', 'public');
        }

        Announcement::create($data);

        $this->closeCreateModal();
        session()->flash('success', 'Announcement created successfully.');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,event,urgent,maintenance',
            'image' => 'nullable|image|max:2048',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $announcement = Announcement::findOrFail($this->editId);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'expires_at' => $this->expires_at ?: null,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
        ];

        if ($this->image) {
            if ($announcement->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $announcement->image_url));
            }
            $data['image_url'] = '/storage/' . $this->image->store('announcements', 'public');
        }

        $announcement->update($data);

        $this->closeEditModal();
        session()->flash('success', 'Announcement updated successfully.');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $announcement = Announcement::findOrFail($this->deleteId);
        
        if ($announcement->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $announcement->image_url));
        }

        $announcement->delete();
        
        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'Announcement deleted successfully.');
    }

    private function resetForm()
    {
        $this->title = '';
        $this->content = '';
        $this->type = 'general';
        $this->image = null;
        $this->expires_at = '';
        $this->is_active = true;
        $this->is_featured = false;
        $this->currentImageUrl = null;
    }
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-base-content">Announcements</h1>
                <p class="text-base-content/70 mt-1">Manage and publish announcements for the portal</p>
            </div>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="openCreateModal">
                New Announcement
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
                        <x-mary-icon name="o-megaphone" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Total</div>
                    <div class="stat-value text-primary">{{ $this->announcements->total() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <x-mary-icon name="o-check-circle" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Active</div>
                    <div class="stat-value text-success">{{ $this->announcements->where('is_active', true)->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <x-mary-icon name="o-star" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Featured</div>
                    <div class="stat-value text-warning">{{ $this->announcements->where('is_featured', true)->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-error">
                        <x-mary-icon name="o-clock" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Expired</div>
                    <div class="stat-value text-error">{{ $this->announcements->where('expires_at', '<', now())->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Announcements Table -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <x-mary-table :headers="[
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'type', 'label' => 'Type'],
                    ['key' => 'is_active', 'label' => 'Status'],
                    ['key' => 'is_featured', 'label' => 'Featured'],
                    ['key' => 'expires_at', 'label' => 'Expires'],
                    ['key' => 'actions', 'label' => 'Actions', 'sortable' => false]
                ]" :rows="$this->announcements" with-pagination>
                    
                    @scope('cell_title', $announcement)
                        <div>
                            <div class="font-semibold">{{ $announcement->title }}</div>
                            <div class="text-sm opacity-70 truncate max-w-xs">{{ Str::limit($announcement->content, 60) }}</div>
                        </div>
                    @endscope

                    @scope('cell_type', $announcement)
                        <x-mary-badge 
                            :value="$announcement->type" 
                            class="badge-ghost"
                        />
                    @endscope

                    @scope('cell_is_active', $announcement)
                        <x-mary-badge 
                            :value="$announcement->is_active ? 'Active' : 'Inactive'" 
                            class="{{ $announcement->is_active ? 'badge-success' : 'badge-error' }}"
                        />
                    @endscope

                    @scope('cell_is_featured', $announcement)
                        @if($announcement->is_featured)
                            <x-mary-icon name="o-star" class="w-5 h-5 text-warning" />
                        @endif
                    @endscope

                    @scope('cell_expires_at', $announcement)
                        @if($announcement->expires_at)
                            <span class="{{ $announcement->expires_at->isPast() ? 'text-error' : 'text-base-content' }}">
                                {{ $announcement->expires_at->format('M j, Y') }}
                            </span>
                        @else
                            <span class="text-base-content/50">Never</span>
                        @endif
                    @endscope

                    @scope('cell_actions', $announcement)
                        <div class="flex gap-2">
                            <x-mary-button 
                                icon="o-pencil" 
                                size="xs" 
                                class="btn-ghost"
                                wire:click="openEditModal({{ $announcement->id }})"
                            />
                            <x-mary-button 
                                icon="o-trash" 
                                size="xs" 
                                class="btn-ghost text-error"
                                wire:click="confirmDelete({{ $announcement->id }})"
                            />
                        </div>
                    @endscope
                </x-mary-table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <x-mary-modal wire:model="showCreateModal" title="Create Announcement" class="backdrop-blur">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-mary-input wire:model="title" label="Title" required />
                <x-mary-select wire:model="type" label="Type" :options="[
                    ['id' => 'general', 'name' => 'General'],
                    ['id' => 'event', 'name' => 'Event'],
                    ['id' => 'urgent', 'name' => 'Urgent'],
                    ['id' => 'maintenance', 'name' => 'Maintenance']
                ]" required />
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="content" label="Content" rows="4" required />
                </div>
                <x-mary-datetime wire:model="expires_at" label="Expires At (optional)" />
                <div class="md:col-span-2">
                    <x-mary-file wire:model="image" label="Image (optional)" accept="image/*" />
                </div>
                <div class="flex gap-4 md:col-span-2">
                    <x-mary-checkbox wire:model="is_active" label="Active" />
                    <x-mary-checkbox wire:model="is_featured" label="Featured" />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="closeCreateModal" />
                <x-mary-button label="Create" wire:click="store" class="btn-primary" />
            </x-slot:actions>
    </x-mary-modal>

    <!-- Edit Modal -->
    <x-mary-modal wire:model="showEditModal" title="Edit Announcement" class="backdrop-blur">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-mary-input wire:model="title" label="Title" required />
                <x-mary-select wire:model="type" label="Type" :options="[
                    ['id' => 'general', 'name' => 'General'],
                    ['id' => 'event', 'name' => 'Event'],
                    ['id' => 'urgent', 'name' => 'Urgent'],
                    ['id' => 'maintenance', 'name' => 'Maintenance']
                ]" required />
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="content" label="Content" rows="4" required />
                </div>
                <x-mary-datetime wire:model="expires_at" label="Expires At (optional)" />
                
                @if($currentImageUrl)
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Current Image</span>
                        </label>
                        <div class="flex items-center gap-4 p-4 bg-base-200 rounded-lg">
                            <img src="{{ $currentImageUrl }}" alt="Current image" class="w-20 h-20 object-cover rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm font-medium">{{ basename($currentImageUrl) }}</p>
                                <p class="text-xs text-base-content/70">Click below to change image</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="md:col-span-2">
                    <x-mary-file wire:model="image" label="Image (optional - leave blank to keep current)" accept="image/*" />
                </div>
                <div class="flex gap-4 md:col-span-2">
                    <x-mary-checkbox wire:model="is_active" label="Active" />
                    <x-mary-checkbox wire:model="is_featured" label="Featured" />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="closeEditModal" />
                <x-mary-button label="Update" wire:click="update" class="btn-primary" />
            </x-slot:actions>
    </x-mary-modal>

    <!-- Delete Confirmation Modal -->
    <x-mary-modal wire:model="showDeleteModal" title="Delete Announcement" class="backdrop-blur">
        <p>Are you sure you want to delete this announcement? This action cannot be undone.</p>
        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="$set('showDeleteModal', false)" />
            <x-mary-button label="Delete" wire:click="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>