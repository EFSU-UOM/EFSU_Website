<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\BoardingPlace;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination;

    // Filters
    public $search = '';
    public $maxDistance = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $minCapacity = '';

    public function mount()
    {
        $this->search = request('search', '');
        $this->maxDistance = request('maxDistance', '');
        $this->minPrice = request('minPrice', '');
        $this->maxPrice = request('maxPrice', '');
        $this->minCapacity = request('minCapacity', '');
    }

    public function getPlacesProperty()
    {
        $query = BoardingPlace::with(['user', 'ratings'])->withCount('comments')->active();

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

<div>
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
                    <a href="{{ route('boarding.place.create') }}" class="btn btn-primary">
                        <x-mary-icon name="o-plus" class="w-5 h-5" />
                        Post Boarding Place
                    </a>
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

                            <!-- Rating Display -->
                            @if ($place->average_rating > 0)
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="rating rating-sm">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <div class="mask mask-star-2 opacity-100 {{ $i <= $place->average_rating ? 'bg-amber-500' : 'bg-neutral-300' }}"></div>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-base-content/70">
                                        {{ $place->average_rating }} ({{ $place->rating_count }})
                                    </span>
                                </div>
                            @endif

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
                        <a href="{{ route('boarding.place.create') }}" class="btn btn-primary">
                            <x-mary-icon name="o-plus" class="w-5 h-5" />
                            Post First Place
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>

</section>

</div>
