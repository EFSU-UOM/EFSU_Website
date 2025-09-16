<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\LostAndFound;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination, WithFileUploads;

    public $showCreateForm = false;

    // Form fields
    public $type = '';
    public $title = '';
    public $description = '';
    public $location = '';
    public $contact_info = '';
    public $item_date = '';
    public $image = null;

    // Filters
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $locationFilter = '';


    protected $rules = [
        'type' => 'required|in:lost,found',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'nullable|string|max:255',
        'contact_info' => 'nullable|string|max:255',
        'item_date' => 'nullable|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function mount()
    {
        $this->search = request('search', '');
        $this->typeFilter = request('type', '');
        $this->statusFilter = request('status', '');
        $this->locationFilter = request('location', '');
    }

    public function getItemsProperty()
    {
        $query = LostAndFound::with('user');

        if (!empty($this->typeFilter)) {
            $query->where('type', $this->typeFilter);
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('location', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->locationFilter)) {
            $query->where('location', 'like', "%{$this->locationFilter}%");
        }

        return $query->orderBy('created_at', 'desc')->paginate(12);
    }

    public function openCreateForm()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isBanned()) {
            session()->flash('error', 'You are banned and cannot post lost and found items.');
            return;
        }

        $this->resetForm();
        $this->showCreateForm = true;
    }

    public function closeCreateForm()
    {
        $this->showCreateForm = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function store()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isBanned()) {
            session()->flash('error', 'You are banned and cannot post lost and found items.');
            return;
        }

        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'contact_info' => $this->contact_info,
            'item_date' => $this->item_date,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('lost-and-found', 'public');
        }

        LostAndFound::create($data);

        $this->closeCreateForm();
        session()->flash('success', 'Item posted successfully!');
        $this->resetPage();
    }

    public function delete($id)
    {
        $item = LostAndFound::find($id);

        if ($item && $item->user_id === auth()->id()) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $item->delete();
            session()->flash('success', 'Item deleted successfully!');
        }
    }

    public function updateStatus($id, $status)
    {
        $item = LostAndFound::find($id);

        if ($item && $item->user_id === auth()->id()) {
            $item->update(['status' => $status]);
            session()->flash('success', 'Status updated successfully!');
        }
    }

    public function clearFilters()
    {
        $this->reset(['search', 'typeFilter', 'statusFilter', 'locationFilter']);
        $this->resetPage();
    }


    private function resetForm()
    {
        $this->reset(['type', 'title', 'description', 'location', 'contact_info', 'item_date', 'image']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingLocationFilter()
    {
        $this->resetPage();
    }
}; ?>

<section>
    <!-- Page Header -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <x-mary-card class="bg-base-100 shadow-none border-0">
                <h1 class="text-4xl font-bold text-base-content mb-4">Lost & Found</h1>
                <p class="text-xl text-base-content/70 max-w-2xl mx-auto mb-6">
                    Help your fellow students find their lost items or reunite found items with their owners.
                </p>
                @auth
                    <x-mary-button class="btn-primary" @click="$wire.openCreateForm()">
                        <x-mary-icon name="o-plus" class="w-5 h-5" />
                        Post Lost/Found Item
                    </x-mary-button>
                @else
                    <p class="text-base-content/60">
                        <a href="{{ route('login') }}" class="link link-primary">Sign in</a> to post lost or found items
                    </p>
                @endauth
            </x-mary-card>
        </div>
    </section>

    <!-- Success Messages -->
    @if (session('success'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-4">
            <x-mary-alert icon="o-check-circle" class="alert-success">
                {{ session('success') }}
            </x-mary-alert>
        </div>
    @endif

    <!-- Create Form Modal -->
    <x-mary-modal wire:model="showCreateForm" title="Post Lost/Found Item" class="backdrop-blur">
        <div class="space-y-4">
            <!-- Item Type -->
            <div>
                <x-mary-radio wire:model="type" :options="[
                    ['id' => 'lost', 'name' => 'Lost Item - I lost something'],
                    ['id' => 'found', 'name' => 'Found Item - I found something'],
                ]" option-value="id" option-label="name" />
                @error('type')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="md:col-span-2">
                    <x-mary-input wire:model="title" label="Item Title"
                        placeholder="e.g., Black iPhone 14 Pro, Blue Backpack, etc." required />
                    @error('title')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="description" label="Description"
                        placeholder="Provide detailed description including color, brand, distinctive features, etc."
                        rows="4" required />
                    @error('description')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Location -->
                <x-mary-input wire:model="location" label="Location" placeholder="Library, Cafeteria, etc." />
                @error('location')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <!-- Date -->
                <x-mary-input wire:model="item_date" label="Date Lost/Found" type="date" />
                @error('item_date')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <!-- Contact Info -->
                <div class="md:col-span-2">
                    <x-mary-input wire:model="contact_info" label="Contact Information (Optional)"
                        placeholder="Email, phone, or preferred contact method" />
                    @error('contact_info')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <x-mary-file wire:model="image" label="Item Photo (Optional)" accept="image/*" crop-after-change>
                        <img src="{{ $image?->temporaryUrl() ?? '/placeholder.avif' }}"
                            class="h-32 w-32 object-cover rounded-lg">
                    </x-mary-file>
                </div>
            </div>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="closeCreateForm" />
            <x-mary-button label="Post Item" wire:click="store" class="btn-primary" />
        </x-slot:actions>
    </x-mary-modal>

    <!-- Filters -->
    <section class="py-8 bg-base-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <x-mary-input wire:model.live.debounce.300ms="search" placeholder="Search items..."
                    icon="o-magnifying-glass" />

                <!-- Type Filter -->
                <x-mary-select wire:model.live="typeFilter" placeholder="All Types">
                    <option value="">All Types</option>
                    <option value="lost">Lost Items</option>
                    <option value="found">Found Items</option>
                </x-mary-select>

                <!-- Status Filter -->
                <x-mary-select wire:model.live="statusFilter" placeholder="All Status">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="owner_found">Owner Found</option>
                    <option value="lost_item_obtained">Item Obtained</option>
                </x-mary-select>

                <!-- Location Filter -->
                <x-mary-input wire:model.live.debounce.300ms="locationFilter" placeholder="Filter by location..."
                    icon="o-map-pin" />

                <!-- Clear Filters -->
                <x-mary-button class="btn-ghost" wire:click="clearFilters">
                    Clear Filters
                </x-mary-button>
            </div>
        </div>
    </section>

    <!-- Items Grid -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($this->items->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($this->items as $item)
                        <div class="relative">
                            <a href="{{ route('lost-and-found.detail', $item->id) }}" class="block">
                                <x-mary-card class="hover:shadow-lg transition-shadow cursor-pointer">
                                    <!-- Image -->
                                    @if ($item->image)
                                        <div class="h-48 bg-base-200 rounded-lg overflow-hidden mb-4">
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="h-48 bg-base-200 rounded-lg flex items-center justify-center mb-4">
                                            <x-mary-icon name="o-photo" class="w-12 h-12 text-base-content/40" />
                                        </div>
                                    @endif

                                    <!-- Type Badge -->
                                    <div class="flex justify-between items-start mb-3">
                                        <x-mary-badge :value="$item->type_label"
                                            class="{{ $item->type === 'lost' ? 'badge-error' : 'badge-success' }}" />
                                        <x-mary-badge :value="$item->status_label"
                                            class="{{ $item->status === 'active' ? 'badge-primary' : 'badge-secondary' }}" />
                                    </div>

                                    <!-- Content -->
                                    <h3 class="text-lg font-semibold text-base-content mb-2 line-clamp-2">
                                        {{ $item->title }}
                                    </h3>

                                    <p class="text-base-content/70 text-sm mb-3 line-clamp-3">
                                        {{ $item->description }}
                                    </p>

                                    @if ($item->location)
                                        <div class="flex items-center text-base-content/60 text-sm mb-3">
                                            <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-1" />
                                            {{ $item->location }}
                                        </div>
                                    @endif

                                    <div class="flex items-center text-base-content/60 text-sm">
                                        <x-mary-icon name="o-user" class="w-4 h-4 mr-1" />
                                        {{ $item->user->name }}
                                        <span class="mx-2">•</span>
                                        {{ $item->created_at->diffForHumans() }}
                                    </div>
                                </x-mary-card>
                            </a>

                            <!-- Actions dropdown positioned absolutely -->
                            @auth
                                @if ($item->user_id === auth()->id())
                                    <div class="absolute top-4 right-4 z-10">
                                        <div class="dropdown dropdown-end">
                                            <x-mary-button tabindex="0" class="btn-ghost btn-sm" onclick="event.stopPropagation();">
                                                <x-mary-icon name="o-ellipsis-vertical" class="w-4 h-4" />
                                            </x-mary-button>
                                            <ul tabindex="0"
                                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                @if ($item->status === 'active')
                                                    @if ($item->type === 'lost')
                                                        <li><a
                                                                wire:click="updateStatus({{ $item->id }}, 'owner_found')">Mark
                                                                as Found</a></li>
                                                    @else
                                                        <li><a
                                                                wire:click="updateStatus({{ $item->id }}, 'lost_item_obtained')">Mark
                                                                as Returned</a></li>
                                                    @endif
                                                @else
                                                    <li><a wire:click="updateStatus({{ $item->id }}, 'active')">Mark
                                                            as
                                                            Active</a></li>
                                                @endif
                                                <li><a wire:click="delete({{ $item->id }})"
                                                        wire:confirm="Are you sure you want to delete this post?"
                                                        class="text-error">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $this->items->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <x-mary-icon name="o-magnifying-glass" class="w-16 h-16 text-base-content/40 mx-auto mb-4" />
                    <h3 class="text-xl font-semibold text-base-content mb-2">No items found</h3>
                    <p class="text-base-content/70 mb-6">
                        No lost or found items match your search criteria. Try adjusting your filters.
                    </p>
                    @auth
                        <x-mary-button class="btn-primary" @click="$wire.openCreateForm()">
                            <x-mary-icon name="o-plus" class="w-5 h-5" />
                            Post First Item
                        </x-mary-button>
                    @endauth
                </div>
            @endif
        </div>
    </section>

</section>
