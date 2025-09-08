<?php

use App\Models\Event;
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
    public $type = 'general';
    public $location = '';
    public $image = null;
    public $currentImageUrl = null;
    public $start_datetime = '';
    public $end_datetime = '';
    public $requires_registration = false;
    public $max_participants = '';
    public $facebook_page_url = '';
    public $facebook_album_urls = '';

    public function mount()
    {
        //
    }

    public function getEventsProperty()
    {
        return Event::latest()->paginate(10);
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
        $event = Event::findOrFail($id);
        $this->editId = $id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->type = $event->type;
        $this->location = $event->location;
        $this->start_datetime = $event->start_datetime ? $event->start_datetime->format('Y-m-d\TH:i') : '';
        $this->end_datetime = $event->end_datetime ? $event->end_datetime->format('Y-m-d\TH:i') : '';
        $this->requires_registration = $event->requires_registration;
        $this->max_participants = $event->max_participants;
        $this->facebook_page_url = $event->facebook_page_url;
        $this->facebook_album_urls = is_array($event->facebook_album_urls) ? implode("\n", $event->facebook_album_urls) : '';
        $this->currentImageUrl = $event->image_url;
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
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'max_participants' => 'nullable|integer|min:1',
            'facebook_page_url' => 'nullable|url',
            'facebook_album_urls' => 'nullable|string',
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'location' => $this->location,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'requires_registration' => $this->requires_registration,
            'max_participants' => $this->max_participants ?: null,
            'facebook_page_url' => $this->facebook_page_url,
            'facebook_album_urls' => $this->facebook_album_urls ? array_filter(explode("\n", $this->facebook_album_urls)) : null,
        ];

        if ($this->image) {
            $data['image_url'] = $this->image->store('events', 'public');
        }

        Event::create($data);

        $this->closeCreateModal();
        session()->flash('success', 'Event created successfully.');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|file|image|max:2048',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'max_participants' => 'nullable|integer|min:1',
            'facebook_page_url' => 'nullable|url',
            'facebook_album_urls' => 'nullable|string',
        ]);

        $event = Event::findOrFail($this->editId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'location' => $this->location,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'requires_registration' => $this->requires_registration,
            'max_participants' => $this->max_participants ?: null,
            'facebook_page_url' => $this->facebook_page_url,
            'facebook_album_urls' => $this->facebook_album_urls ? array_filter(explode("\n", $this->facebook_album_urls)) : null,
        ];

        if ($this->image && is_object($this->image)) {
            if ($event->image_url) {
                Storage::disk('public')->delete($event->image_url);
            }
            $data['image_url'] = $this->image->store('events', 'public');
        }

        $event->update($data);

        $this->closeEditModal();
        session()->flash('success', 'Event updated successfully.');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $event = Event::findOrFail($this->deleteId);

        if ($event->image_url) {
            Storage::disk('public')->delete($event->image_url);
        }

        $event->delete();

        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'Event deleted successfully.');
    }

    private function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->type = 'general';
        $this->location = '';
        $this->image = null;
        $this->start_datetime = '';
        $this->end_datetime = '';
        $this->requires_registration = false;
        $this->max_participants = '';
        $this->facebook_page_url = '';
        $this->facebook_album_urls = '';
        $this->currentImageUrl = null;
    }
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-base-content">Events</h1>
                <p class="text-base-content/70 mt-1">Manage events for the portal</p>
            </div>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="openCreateModal">
                New Event
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
                        <x-mary-icon name="o-calendar" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Total</div>
                    <div class="stat-value text-primary">{{ $this->events->total() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <x-mary-icon name="o-clock" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Upcoming</div>
                    <div class="stat-value text-success">
                        {{ $this->events->where('start_datetime', '>', now())->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <x-mary-icon name="o-user-group" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Reg. Required</div>
                    <div class="stat-value text-warning">
                        {{ $this->events->where('requires_registration', true)->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-info">
                        <x-mary-icon name="o-check" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Past</div>
                    <div class="stat-value text-info">{{ $this->events->where('end_datetime', '<', now())->count() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Table -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <x-mary-table :headers="[
                    ['key' => 'title', 'label' => 'Title'],
                    ['key' => 'type', 'label' => 'Type'],
                    ['key' => 'location', 'label' => 'Location'],
                    ['key' => 'start_datetime', 'label' => 'Start Date'],
                    ['key' => 'requires_registration', 'label' => 'Registration'],
                    ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
                ]" :rows="$this->events" with-pagination>

                    @scope('cell_title', $event)
                        <div>
                            <div class="font-semibold">{{ $event->title }}</div>
                            <div class="text-sm opacity-70 truncate max-w-xs">{{ Str::limit($event->description, 60) }}
                            </div>
                        </div>
                    @endscope

                    @scope('cell_type', $event)
                        <x-mary-badge :value="$event->type" class="badge-ghost" />
                    @endscope

                    @scope('cell_location', $event)
                        <span class="text-sm">{{ $event->location }}</span>
                    @endscope

                    @scope('cell_start_datetime', $event)
                        <div>
                            <div class="font-semibold">{{ $event->start_datetime->format('M j, Y') }}</div>
                            <div class="text-sm opacity-70">{{ $event->start_datetime->format('g:i A') }}</div>
                        </div>
                    @endscope

                    @scope('cell_requires_registration', $event)
                        @if ($event->requires_registration)
                            <x-mary-badge value="Required" class="badge-warning" />
                        @else
                            <x-mary-badge value="Open" class="badge-success" />
                        @endif
                    @endscope

                    @scope('cell_actions', $event)
                        <div class="flex gap-2">
                            <x-mary-button icon="o-pencil" size="xs" class="btn-ghost"
                                wire:click="openEditModal({{ $event->id }})" />
                            <x-mary-button icon="o-trash" size="xs" class="btn-ghost text-error"
                                wire:click="confirmDelete({{ $event->id }})" />
                        </div>
                    @endscope
                </x-mary-table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    @if ($showCreateModal)
        <x-mary-modal wire:model="showCreateModal" title="Create Event" class="backdrop-blur">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-mary-input wire:model="title" label="Title" required />
                <x-mary-input wire:model="type" label="Type" required />
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="description" label="Description" rows="4" required />
                </div>
                <x-mary-input wire:model="location" label="Location" required />
                <x-mary-input wire:model="max_participants" label="Max Participants (optional)" type="number" />
                <x-mary-datetime wire:model="start_datetime" label="Start Date & Time" required />
                <x-mary-datetime wire:model="end_datetime" label="End Date & Time" required />
                <x-mary-input wire:model="facebook_page_url" label="Facebook Page URL (optional)" type="url" />
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="facebook_album_urls" label="Facebook Album URLs (one per line)"
                        rows="3" />
                </div>
                <div class="md:col-span-2">
                    <x-mary-file wire:model="image" label="Image" accept="image/*" crop-after-change>
                        <img src="{{ $image ? $image->temporaryUrl() : '/placeholder.avif' }}" alt="Preview"
                            class="w-full h-full object-cover rounded-lg" />
                    </x-mary-file>
                </div>
                <div class="md:col-span-2">
                    <x-mary-checkbox wire:model="requires_registration" label="Requires Registration" />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="closeCreateModal" />
                <x-mary-button label="Create" wire:click="store" class="btn-primary" />
            </x-slot:actions>
        </x-mary-modal>
    @endif
    <!-- Edit Modal -->
    <x-mary-modal wire:model="showEditModal" title="Edit Event" class="backdrop-blur">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-mary-input wire:model="title" label="Title" required />
            <x-mary-input wire:model="type" label="Type" required />
            <div class="md:col-span-2">
                <x-mary-textarea wire:model="description" label="Description" rows="4" required />
            </div>
            <x-mary-input wire:model="location" label="Location" required />
            <x-mary-input wire:model="max_participants" label="Max Participants (optional)" type="number" />
            <x-mary-datetime wire:model="start_datetime" label="Start Date & Time" required />
            <x-mary-datetime wire:model="end_datetime" label="End Date & Time" required />
            <x-mary-input wire:model="facebook_page_url" label="Facebook Page URL (optional)" type="url" />
            <div class="md:col-span-2">
                <x-mary-textarea wire:model="facebook_album_urls" label="Facebook Album URLs (one per line)"
                    rows="3" />
            </div>

            <div class="md:col-span-2">
                <x-mary-file wire:model="image" label="Image" accept="image/*" crop-after-change>
                    <img src="{{ $image ? $image->temporaryUrl() : ($currentImageUrl ? Storage::url($currentImageUrl) : '/placeholder.avif') }}" alt="Preview"
                        class="w-full h-full object-cover rounded-lg" />
                </x-mary-file>
            </div>
            <div class="md:col-span-2">
                <x-mary-checkbox wire:model="requires_registration" label="Requires Registration" />
            </div>
        </div>
        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="closeEditModal" />
            <x-mary-button label="Update" wire:click="update" class="btn-primary" />
        </x-slot:actions>
    </x-mary-modal>

    <!-- Delete Confirmation Modal -->
    <x-mary-modal wire:model="showDeleteModal" title="Delete Event" class="backdrop-blur">
        <p>Are you sure you want to delete this event? This action cannot be undone.</p>
        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="$set('showDeleteModal', false)" />
            <x-mary-button label="Delete" wire:click="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>
