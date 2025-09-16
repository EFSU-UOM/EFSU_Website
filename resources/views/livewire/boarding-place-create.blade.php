<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Models\BoardingPlace;
use Illuminate\Support\Facades\Storage;
use Mary\Traits\WithMediaSync;

new class extends Component {
    use WithFileUploads, WithMediaSync;

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
        $this->library = new Collection();
    }

    public function store()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isBanned()) {
            session()->flash('error', 'You are banned and cannot create boarding places.');
            return redirect()->route('boarding.places');
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

        session()->flash('success', 'Boarding place posted successfully!');
        return redirect()->route('boarding.places');
    }

    public function cancel()
    {
        return redirect()->route('boarding.places');
    }
}; ?>

<div>
    <!-- Page Header -->
    <section class="bg-base-100 py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-base-content mb-4">Post Boarding Place</h1>
                <p class="text-xl text-base-content/70">Share a boarding place to help fellow students find accommodation near the university.</p>
            </div>
        </div>
    </section>

    <!-- Create Form -->
    <section class="py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <x-mary-card>
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
                        <x-mary-input class="hidden" wire:model="latitude" type="number" step="any"
                            placeholder="e.g., 6.9271" />
                        @error('latitude')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror

                        <x-mary-input class="hidden"  wire:model="longitude" type="number" step="any"
                            placeholder="e.g., 79.8612" />
                        @error('longitude')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Google Map -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-base-content mb-2">
                                Click on map to set location (Optional)
                            </label>
                            <div wire:ignore>
                                <div id="map" class="w-full h-96 rounded-lg border border-base-300" style="min-height: 400px; height: 400px;"></div>
                            </div>
                        </div>

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

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 pt-6">
                        <x-mary-button label="Cancel" wire:click="cancel" class="btn-ghost" />
                        <x-mary-button label="Post Boarding Place" wire:click="store" class="btn-primary" />
                    </div>
                </div>
            </x-mary-card>
        </div>
    </section>

    <!-- Map Styles -->
    <style>
        #map {
            width: 100% !important;
            height: 400px !important;
            min-height: 400px !important;
        }
        
        /* Ensure map container has proper dimensions */
        .gm-style {
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <!-- Google Maps Integration -->
    <script>
        let map;
        let marker;
        let mapInitialized = false;

        function updateMarkerFromInputs() {
            if (!marker) return;
            
            const lat = parseFloat(document.querySelector('input[wire\\:model="latitude"]')?.value);
            const lng = parseFloat(document.querySelector('input[wire\\:model="longitude"]')?.value);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                const position = { lat, lng };
                marker.setPosition(position);
                map.setCenter(position);
            }
        }

        function initializeMap() {
            const mapElement = document.getElementById('map');
            if (!mapElement || mapInitialized) {
                console.log('Map element not found or already initialized');
                return;
            }
            
            console.log('Initializing Google Map...');
            
            // Default to EFSU coordinates
            const defaultLocation = { lat: 6.7951301939508255, lng: 79.90086078643799 };
            
            map = new google.maps.Map(mapElement, {
                zoom: 16,
                center: defaultLocation,
                mapTypeControl: false,
            });

            marker = new google.maps.Marker({
                map,
                draggable: true,
                position: defaultLocation
            });

            mapInitialized = true;
            console.log('Map initialized successfully');

            // Handle map clicks - use wire:ignore to prevent Livewire from destroying the map
            map.addListener("click", (e) => {
                const clickedLocation = e.latLng;
                const coords = clickedLocation.toJSON();
                
                console.log('Clicked location:', coords);
                
                marker.setPosition(clickedLocation);
                map.panTo(clickedLocation);
                
                // Update Livewire component fields without triggering re-render
                @this.set('latitude', coords.lat.toFixed(8), false);
                @this.set('longitude', coords.lng.toFixed(8), false);
                
                // Manually update the input values
                const latInput = document.querySelector('input[wire\\:model="latitude"]');
                const lngInput = document.querySelector('input[wire\\:model="longitude"]');
                
                if (latInput) latInput.value = coords.lat.toFixed(8);
                if (lngInput) lngInput.value = coords.lng.toFixed(8);
            });

            // Handle marker drag
            marker.addListener('dragend', (e) => {
                const coords = e.latLng.toJSON();
                
                console.log('Marker dragged to:', coords);
                
                // Update Livewire component fields without triggering re-render
                @this.set('latitude', coords.lat.toFixed(8), false);
                @this.set('longitude', coords.lng.toFixed(8), false);
                
                // Manually update the input values
                const latInput = document.querySelector('input[wire\\:model="latitude"]');
                const lngInput = document.querySelector('input[wire\\:model="longitude"]');
                
                if (latInput) latInput.value = coords.lat.toFixed(8);
                if (lngInput) lngInput.value = coords.lng.toFixed(8);
            });
        }

        // Global callback for Google Maps API
        window.initMap = function() {
            console.log('Google Maps API loaded');
            
            // Since we're on a dedicated page, initialize immediately when element is ready
            setTimeout(() => {
                const mapElement = document.getElementById('map');
                if (mapElement && !mapInitialized) {
                    initializeMap();
                }
            }, 100);
        };

        // Also try when DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (window.google && window.google.maps && document.getElementById('map') && !mapInitialized) {
                    initializeMap();
                }
            }, 200);
        });
    </script>

    <!-- Load Google Maps API -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('google_maps.api_key') }}&callback=initMap"></script>
</div>