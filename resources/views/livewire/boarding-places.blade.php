<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Models\BoardingPlace;
use Illuminate\Support\Facades\Storage;
use Mary\Traits\WithMediaSync;

new class extends Component {
    use WithPagination, WithFileUploads, WithMediaSync;

    public $showCreateForm = false;

    // Form fields
    public $title = '';
    public $description = '';
    public $location = '';
    public $latitude = '';
    public $longitude = '';
    public $distance_to_university = '';
    public $price = '';
    public $payment_method = '';
    public $capacity = '';
    public $contact_phone = '';
    public $contact_email = '';

    public Collection $library;
    #[Rule(['files.*' => 'image|max:1024'])]
    public array $files = [];

    // Filters
    public $search = '';
    public $maxDistance = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $minCapacity = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'distance_to_university' => 'nullable|numeric|min:0',
        'price' => 'nullable|numeric|min:0',
        'payment_method' => 'nullable|string|max:255',
        'capacity' => 'nullable|integer|min:1',
        'contact_phone' => 'nullable|string|max:255',
        'contact_email' => 'nullable|email|max:255',
        'files' => 'required|array|min:1',
        'files.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function mount()
    {
        $this->search = request('search', '');
        $this->maxDistance = request('maxDistance', '');
        $this->minPrice = request('minPrice', '');
        $this->maxPrice = request('maxPrice', '');
        $this->minCapacity = request('minCapacity', '');
        $this->library = new Collection();
    }

    public function getPlacesProperty()
    {
        $query = BoardingPlace::with('user')->withCount('comments')->active();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('location', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->maxDistance)) {
            $query->withinDistance($this->maxDistance);
        }

        if (!empty($this->minPrice) || !empty($this->maxPrice)) {
            $query->withinPriceRange($this->minPrice, $this->maxPrice);
        }

        if (!empty($this->minCapacity)) {
            $query->where('capacity', '>=', $this->minCapacity);
        }

        return $query->orderBy('created_at', 'desc')->paginate(12);
    }

    public function openCreateForm()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
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

        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'latitude' => $this->latitude ?: null,
            'longitude' => $this->longitude ?: null,
            'distance_to_university' => $this->distance_to_university ?: null,
            'price' => $this->price ?: null,
            'payment_method' => $this->payment_method ?: null,
            'capacity' => $this->capacity ?: null,
            'contact_phone' => $this->contact_phone ?: null,
            'contact_email' => $this->contact_email ?: null,
        ];

        if (!empty($this->files)) {
            $imagePaths = [];
            foreach ($this->files as $file) {
                $imagePaths[] = $file->store('boarding-places', 'public');
            }
            $data['images'] = $imagePaths;
        }

        BoardingPlace::create($data);

        $this->closeCreateForm();
        session()->flash('success', 'Boarding place posted successfully!');
        $this->resetPage();
    }

    public function delete($id)
    {
        $place = BoardingPlace::find($id);

        if ($place && $place->user_id === auth()->id()) {
            if ($place->images) {
                foreach ($place->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            $place->delete();
            session()->flash('success', 'Boarding place deleted successfully!');
        }
    }

    public function clearFilters()
    {
        $this->reset(['search', 'maxDistance', 'minPrice', 'maxPrice', 'minCapacity']);
        $this->resetPage();
    }

    public function viewDetails($placeId)
    {
        return redirect()->route('boarding.place.details', $placeId);
    }

    private function resetForm()
    {
        $this->reset(['title', 'description', 'location', 'latitude', 'longitude', 'distance_to_university', 'price', 'payment_method', 'capacity', 'contact_phone', 'contact_email', 'files']);
        $this->library = new Collection();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMaxDistance()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function updatingMinCapacity()
    {
        $this->resetPage();
    }
}; ?>

<section>
    <!-- Page Header -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <x-mary-card class="bg-base-100 shadow-none border-0">
                <h1 class="text-4xl font-bold text-base-content mb-4">Boarding Places</h1>
                <p class="text-xl text-base-content/70 max-w-2xl mx-auto mb-6">
                    Find the perfect boarding place near the university. Share places you know to help fellow students.
                </p>
                @auth
                    <x-mary-button class="btn-primary" @click="$wire.openCreateForm()">
                        <x-mary-icon name="o-plus" class="w-5 h-5" />
                        Post Boarding Place
                    </x-mary-button>
                @else
                    <p class="text-base-content/60">
                        <a href="{{ route('login') }}" class="link link-primary">Sign in</a> to post boarding places
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
    <x-mary-modal wire:model="showCreateForm" title="Post Boarding Place" class="backdrop-blur" box-class="max-w-4xl">
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div class="md:col-span-2">
                    <x-mary-input wire:model="title" label="Title" placeholder="e.g., Comfortable boarding near EFSU"
                        required />
                    @error('title')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <x-mary-textarea wire:model="description" label="Description"
                        placeholder="Describe the boarding place, amenities, rules, etc." rows="4" required />
                    @error('description')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Location -->
                <x-mary-input wire:model="location" label="Location" placeholder="Street address or area name"
                    required />
                @error('location')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <!-- Distance to University -->
                <x-mary-input wire:model="distance_to_university" label="Distance to University (m)" type="number"
                    step="0.1" />
                @error('distance_to_university')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <!-- Coordinates -->
                <x-mary-input wire:model="latitude" label="Latitude (Optional)" type="number" step="any"
                    placeholder="e.g., 6.9271" />
                @error('latitude')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <x-mary-input wire:model="longitude" label="Longitude (Optional)" type="number" step="any"
                    placeholder="e.g., 79.8612" />
                @error('longitude')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <!-- Price -->
                <x-mary-input wire:model="price" label="Price (Optional)" type="number" step="0.01" />
                @error('price')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <x-mary-select wire:model="payment_method" label="Payment Method" placeholder="Select payment method"
                    :options="[
                        ['name' => 'Per Person', 'id' => 'per_person'],
                        ['name' => 'Per Room', 'id' => 'per_room'],
                        ['name' => 'Per Floor', 'id' => 'per_floor'],
                    ]">
                </x-mary-select>

                <!-- Capacity -->
                <x-mary-input wire:model="capacity" label="Capacity (Optional)" type="number"
                    placeholder="Number of students" />
                @error('capacity')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <!-- Contact Information -->
                <x-mary-input wire:model="contact_phone" label="Contact Phone (Optional)" />
                @error('contact_phone')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <x-mary-input wire:model="contact_email" label="Contact Email (Optional)" type="email" />
                @error('contact_email')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror

                <!-- Image Upload -->
                <div class="md:col-span-2">
                    <x-mary-image-library wire:model="files" wire:library="library" :preview="$library"
                        label="Boarding images" required/>
                    @error('files')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="closeCreateForm" />
            <x-mary-button label="Post Place" wire:click="store" class="btn-primary" />
        </x-slot:actions>
    </x-mary-modal>

    <!-- Filters -->
    <section class="py-8 bg-base-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <!-- Search -->
                <x-mary-input wire:model.live.debounce.300ms="search" placeholder="Search places..."
                    icon="o-magnifying-glass" />

                <!-- Max Distance -->
                <x-mary-input wire:model.live.debounce.300ms="maxDistance" placeholder="Max distance (m)"
                    type="number" />

                <!-- Price Range -->
                <x-mary-input wire:model.live.debounce.300ms="minPrice" placeholder="Min price" type="number" />
                <x-mary-input wire:model.live.debounce.300ms="maxPrice" placeholder="Max price" type="number" />

                <!-- Min Capacity -->
                <x-mary-input wire:model.live.debounce.300ms="minCapacity" placeholder="Min capacity" type="number" />

                <!-- Clear Filters -->
                <x-mary-button class="btn-ghost" wire:click="clearFilters">
                    Clear Filters
                </x-mary-button>
            </div>
        </div>
    </section>

    <!-- Places Grid -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($this->places->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($this->places as $place)
                        <div class="bg-base-100 hover:shadow-lg transition-shadow rounded-lg p-4 cursor-pointer"
                            wire:click="viewDetails({{ $place->id }})">
                            <!-- Images -->
                            @if ($place->images && count($place->images) > 0)
                                <div class="h-48 bg-base-200 rounded-lg overflow-hidden mb-4">
                                    <img src="{{ Storage::url($place->images[0]) }}" alt="{{ $place->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-48 bg-base-200 rounded-lg flex items-center justify-center mb-4">
                                    <x-mary-icon name="o-home" class="w-12 h-12 text-base-content/40" />
                                </div>
                            @endif

                            <!-- Content -->
                            <h3 class="text-lg font-semibold text-base-content mb-2 line-clamp-2">
                                {{ $place->title }}
                            </h3>

                            <p class="text-base-content/70 text-sm mb-3 line-clamp-2">
                                {{ $place->description }}
                            </p>

                            <!-- Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-base-content/60 text-sm">
                                    <x-mary-icon name="o-map-pin" class="w-4 h-4 mr-1" />
                                    {{ $place->location }}
                                </div>

                                @if ($place->distance_to_university)
                                    <div class="flex items-center text-base-content/60 text-sm">
                                        <x-mary-icon name="o-academic-cap" class="w-4 h-4 mr-1" />
                                        {{ $place->formatted_distance }}
                                    </div>
                                @endif

                                @if ($place->price)
                                    <div class="flex items-center text-base-content/60 text-sm">
                                        <x-mary-icon name="o-currency-dollar" class="w-4 h-4 mr-1" />
                                        {{ $place->formatted_price }}
                                    </div>
                                @endif

                                @if ($place->capacity)
                                    <div class="flex items-center text-base-content/60 text-sm">
                                        <x-mary-icon name="o-users" class="w-4 h-4 mr-1" />
                                        {{ $place->capacity }} students
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between text-base-content/60 text-sm mb-4">
                                <div class="flex items-center">
                                    <x-mary-icon name="o-user" class="w-4 h-4 mr-1" />
                                    {{ $place->user->name }}
                                    <span class="mx-2">•</span>
                                    {{ $place->created_at->diffForHumans() }}
                                </div>
                                <div class="flex items-center">
                                    <x-mary-icon name="o-chat-bubble-left" class="w-4 h-4 mr-1" />
                                    {{ $place->comments_count }}
                                </div>
                            </div>

                            <!-- Actions -->
                            @auth
                                @if ($place->user_id === auth()->id())
                                    <div class="flex justify-end">
                                        <div class="dropdown dropdown-end">
                                            <x-mary-button tabindex="0" class="btn-ghost btn-sm"
                                                onclick="event.stopPropagation()">
                                                <x-mary-icon name="o-ellipsis-vertical" class="w-4 h-4" />
                                            </x-mary-button>
                                            <ul tabindex="0"
                                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                <li><a wire:click="delete({{ $place->id }})"
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
                    {{ $this->places->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <x-mary-icon name="o-home" class="w-16 h-16 text-base-content/40 mx-auto mb-4" />
                    <h3 class="text-xl font-semibold text-base-content mb-2">No boarding places found</h3>
                    <p class="text-base-content/70 mb-6">
                        No boarding places match your search criteria. Try adjusting your filters.
                    </p>
                    @auth
                        <x-mary-button class="btn-primary" @click="$wire.openCreateForm()">
                            <x-mary-icon name="o-plus" class="w-5 h-5" />
                            Post First Place
                        </x-mary-button>
                    @endauth
                </div>
            @endif
        </div>
    </section>

</section>
