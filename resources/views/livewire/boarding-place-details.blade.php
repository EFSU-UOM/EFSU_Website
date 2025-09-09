<?php

use Livewire\Volt\Component;
use Illuminate\Support\Collection;
use App\Models\BoardingPlace;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Mary\Traits\WithMediaSync;

new class extends Component {
    use WithFileUploads, WithMediaSync;

    public $boardingPlace;
    public $editMode = false;

    // Form fields for editing
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
    
    public array $files = [];

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
        'files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function mount($id)
    {
        $this->boardingPlace = BoardingPlace::with('user', 'topLevelComments.user', 'topLevelComments.replies.user')->findOrFail($id);
        $this->boardingPlace->incrementViews();
        $this->library = $this->boardingPlace->images ?: new Collection();
    }

    public function enableEdit()
    {
        if (!auth()->check() || $this->boardingPlace->user_id !== auth()->id()) {
            abort(403);
        }

        $this->editMode = true;
        $this->title = $this->boardingPlace->title;
        $this->description = $this->boardingPlace->description;
        $this->location = $this->boardingPlace->location;
        $this->latitude = $this->boardingPlace->latitude;
        $this->longitude = $this->boardingPlace->longitude;
        $this->distance_to_university = $this->boardingPlace->distance_to_university;
        $this->price = $this->boardingPlace->price;
        $this->payment_method = $this->boardingPlace->payment_method;
        $this->capacity = $this->boardingPlace->capacity;
        $this->contact_phone = $this->boardingPlace->contact_phone;
        $this->contact_email = $this->boardingPlace->contact_email;
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->files = [];
        
        // Safely restore images
        $this->library = $this->boardingPlace->images ?: new Collection();
        
        $this->resetValidation();
    }

    public function updatePlace()
    {
        if (!auth()->check() || $this->boardingPlace->user_id !== auth()->id()) {
            abort(403);
        }

        $this->validate();

        $data = [
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

        $this->boardingPlace->update($data);
        
        // Sync media files if any new files were uploaded
        if (!empty($this->files)) {
            $this->syncMedia(
                model: $this->boardingPlace,
                library: 'library',
                files: 'files',
                storage_subpath: 'boarding-places',
                model_field: 'images'
            );
        }
        
        $this->boardingPlace->refresh();
        
        // Safely refresh images
        $this->library = $this->boardingPlace->images ?: new Collection();
        $this->editMode = false;
        $this->files = [];

        session()->flash('success', 'Boarding place updated successfully!');
    }

    public function deletePlace()
    {
        if (!auth()->check() || $this->boardingPlace->user_id !== auth()->id()) {
            abort(403);
        }

        if ($this->boardingPlace->images) {
            foreach ($this->boardingPlace->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $this->boardingPlace->delete();

        session()->flash('success', 'Boarding place deleted successfully!');
        return redirect()->route('boarding.places');
    }

    public function goBack()
    {
        return redirect()->route('boarding.places');
    }
}; ?>

<section class="min-h-screen bg-base-100">
    <!-- Header -->
    <section class="bg-base-200 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-4">
                <x-mary-button wire:click="goBack" class="btn-ghost">
                    <x-mary-icon name="o-arrow-left" class="w-5 h-5" />
                    Back to Boarding Places
                </x-mary-button>
            </div>
            <h1 class="text-3xl font-bold text-base-content">{{ $boardingPlace->title }}</h1>
        </div>
    </section>

    <!-- Success Messages -->
    @if (session('success'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4">
            <x-mary-alert icon="o-check-circle" class="alert-success">
                {{ session('success') }}
            </x-mary-alert>
        </div>
    @endif

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @if ($editMode)
            <!-- Edit Form -->
            <x-mary-card class="mb-8">
                <h4>Edit Boarding Place</h4>
                <div class="space-y-6">
                    <form wire:submit.prevent="updatePlace" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <x-mary-input wire:model="title" label="Title" required />
                                @error('title')
                                    <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-mary-textarea wire:model="description" label="Description" rows="4" required />
                                @error('description')
                                    <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Location -->
                            <x-mary-input wire:model="location" label="Location" required />

                            <!-- Distance -->
                            <x-mary-input wire:model="distance_to_university" label="Distance (m)" type="number"
                                step="1" />

                            <!-- Coordinates -->
                            <x-mary-input wire:model="latitude" label="Latitude" type="number" step="any" />
                            <x-mary-input wire:model="longitude" label="Longitude" type="number" step="any" />

                            <!-- Price -->
                            <x-mary-input wire:model="price" label="Price" type="number" step="0.01" />
                            <x-mary-select wire:model="payment_method" label="Price Period">
                                <option value="">Not specified</option>
                                <option value="per month">Per Month</option>
                                <option value="per semester">Per Semester</option>
                                <option value="per year">Per Year</option>
                            </x-mary-select>

                            <!-- Capacity -->
                            <x-mary-input wire:model="capacity" label="Capacity" type="number" />

                            <!-- Contact -->
                            <x-mary-input wire:model="contact_phone" label="Contact Phone" />
                            <x-mary-input wire:model="contact_email" label="Contact Email" type="email" />

                            <!-- Images -->
                             <div class="md:col-span-2">
                                <x-mary-image-library wire:model="files" wire:library="library" :preview="$library"
                                    label="Boarding images" />
                            </div> 
                        </div>
                    </form>

                    <div class="flex gap-3 pt-4">
                        <x-mary-button label="Cancel" wire:click="cancelEdit" />
                        <x-mary-button label="Update Place" wire:click="updatePlace" class="btn-primary" />
                    </div>
                </div>
            </x-mary-card>
        @else
            <!-- Place Display -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Images Section -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-3 gap-2">
                        @foreach ($boardingPlace->images as $image)
                            <div class="aspect-square bg-base-200 rounded-lg overflow-hidden">
                                <img src="{{ Storage::url($image) }}" alt="{{ $boardingPlace->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Details Section -->
                <div class="space-y-6">
                    <!-- User and Date Info -->
                    <x-mary-card>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <x-mary-icon name="o-user" class="w-5 h-5 mr-2 text-base-content/60" />
                                <span class="font-medium">{{ $boardingPlace->user->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <x-mary-icon name="o-clock" class="w-5 h-5 mr-2 text-base-content/60" />
                                <span
                                    class="text-base-content/80">{{ $boardingPlace->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center">
                                <x-mary-icon name="o-eye" class="w-5 h-5 mr-2 text-base-content/60" />
                                <span class="text-base-content/80">{{ $boardingPlace->views_count }} views</span>
                            </div>
                        </div>
                    </x-mary-card>

                    <!-- Description -->
                    <x-mary-card>
                        <h4>Description</h4>
                        <p class="text-base-content/80 leading-relaxed">{{ $boardingPlace->description }}</p>
                    </x-mary-card>

                    <!-- Details -->
                    <x-mary-card>
                        <h4>Details</h4>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <x-mary-icon name="o-map-pin" class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                                <div>
                                    <p class="text-sm font-medium text-base-content/60">Location</p>
                                    <p class="text-base-content">{{ $boardingPlace->location }}</p>
                                </div>
                            </div>

                            @if ($boardingPlace->distance_to_university)
                                <div class="flex items-start">
                                    <x-mary-icon name="o-academic-cap"
                                        class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                                    <div>
                                        <p class="text-sm font-medium text-base-content/60">Distance to University</p>
                                        <p class="text-base-content">{{ $boardingPlace->formatted_distance }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($boardingPlace->price)
                                <div class="flex items-start">
                                    <x-mary-icon name="o-currency-dollar"
                                        class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                                    <div>
                                        <p class="text-sm font-medium text-base-content/60">Price</p>
                                        <p class="text-base-content">{{ $boardingPlace->formatted_price }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($boardingPlace->capacity)
                                <div class="flex items-start">
                                    <x-mary-icon name="o-users" class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                                    <div>
                                        <p class="text-sm font-medium text-base-content/60">Capacity</p>
                                        <p class="text-base-content">{{ $boardingPlace->capacity }} students</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </x-mary-card>

                    <!-- Contact Information -->
                    @if ($boardingPlace->contact_phone || $boardingPlace->contact_email)
                        <x-mary-card>
                            <h4>Contact Information</h4>
                            <div class="space-y-3">
                                @if ($boardingPlace->contact_phone)
                                    <div class="flex items-center">
                                        <x-mary-icon name="o-phone" class="w-4 h-4 mr-2 text-base-content/60" />
                                        <span class="text-base-content">{{ $boardingPlace->contact_phone }}</span>
                                    </div>
                                @endif
                                @if ($boardingPlace->contact_email)
                                    <div class="flex items-center">
                                        <x-mary-icon name="o-envelope" class="w-4 h-4 mr-2 text-base-content/60" />
                                        <span class="text-base-content">{{ $boardingPlace->contact_email }}</span>
                                    </div>
                                @endif
                            </div>
                        </x-mary-card>
                    @endif

                    <!-- Action Buttons -->
                    @auth
                        @if ($boardingPlace->user_id === auth()->id())
                            <x-mary-card>
                                <h4>Actions</h4>
                                <div class="flex gap-3">
                                    {{-- <x-mary-button class="btn-secondary flex-1" wire:click="enableEdit">
                                        <x-mary-icon name="o-pencil" class="w-5 h-5" />
                                        Edit
                                    </x-mary-button> --}}

                                    <x-mary-button class="btn-error flex-1" wire:click="deletePlace"
                                        wire:confirm="Are you sure you want to delete this boarding place?">
                                        <x-mary-icon name="o-trash" class="w-5 h-5" />
                                        Delete
                                    </x-mary-button>
                                </div>
                            </x-mary-card>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Map -->
            @if ($boardingPlace->latitude && $boardingPlace->longitude)
                <div class="mt-8">
                    <x-mary-card>
                        <h4>Location Map</h4>
                        <div class="aspect-video bg-base-200 rounded-lg overflow-hidden">
                            <iframe
                                src="https://maps.google.com/maps?q={{ $boardingPlace->latitude }},{{ $boardingPlace->longitude }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                class="w-full h-full border-0"></iframe>
                        </div>
                    </x-mary-card>
                </div>
            @endif

            <!-- Comments Section -->
            <div class="mt-8">
                <x-mary-card>
                    <h4>Comments</h4>
                    <livewire:boarding-place-comments :boarding-place-id="$boardingPlace->id" />
                </x-mary-card>
            </div>
        @endif
    </div>
</section>
