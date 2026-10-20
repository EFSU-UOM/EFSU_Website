<?php

use App\Models\GalleryItem;
use function Livewire\Volt\{state, computed, mount};

state(['selectedCategory' => 'all']);

$galleryItems = computed(function () {
    $query = GalleryItem::query();

    if ($this->selectedCategory !== 'all') {
        $query->where('category', $this->selectedCategory);
    }

    return $query->latest()->get();
});

$setCategory = function ($category) {
    $this->selectedCategory = $category;
};

?>

<!-- Gallery Categories -->
<section class="bg-base-200 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-wrap justify-center gap-4">
            <x-mary-button wire:click="setCategory('all')" aria-pressed="{{ $selectedCategory === 'all' ? 'true' : 'false' }}"
                class="rounded-full {{ $selectedCategory === 'all' ? 'btn-primary' : 'btn-neutral' }}">
                All
            </x-mary-button>
            <x-mary-button wire:click="setCategory('events')" aria-pressed="{{ $selectedCategory === 'events' ? 'true' : 'false' }}"
                class="rounded-full {{ $selectedCategory === 'events' ? 'btn-primary' : 'btn-neutral' }}">
                Events
            </x-mary-button>
            <x-mary-button wire:click="setCategory('seminars')" aria-pressed="{{ $selectedCategory === 'seminars' ? 'true' : 'false' }}"
                class="rounded-full {{ $selectedCategory === 'seminars' ? 'btn-primary' : 'btn-neutral' }}">
                Seminars
            </x-mary-button>
            <x-mary-button wire:click="setCategory('trips')" aria-pressed="{{ $selectedCategory === 'trips' ? 'true' : 'false' }}"
                class="rounded-full {{ $selectedCategory === 'trips' ? 'btn-primary' : 'btn-neutral' }}">
                Trips
            </x-mary-button>
            <x-mary-button wire:click="setCategory('activities')" aria-pressed="{{ $selectedCategory === 'activities' ? 'true' : 'false' }}"
                class="rounded-full {{ $selectedCategory === 'activities' ? 'btn-primary' : 'btn-neutral' }}">
                Activities
            </x-mary-button>
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($this->galleryItems as $item)
                @if ($item->link)
                    <a href="{{ $item->link }}" target="_blank" rel="noopener" class="block">
                        <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl border-0"
                            title="{{ $item->title }}" subtitle="{{ $item->description }}">
                            <x-slot:figure>
                                <img src="{{ Storage::url($item->file_path) }}" alt="{{ $item->title }}" loading="lazy"
                                    class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                            </x-slot:figure>
                            <div
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                                <div
                                    class="p-4 text-white opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                            </path>
                                        </svg>
                                        <span class="text-sm">Click to view</span>
                                    </div>
                                </div>
                            </div>
                        </x-mary-card>
                    </a>
                @else
                    <x-mary-card class="group relative overflow-hidden rounded-xl border-0"
                        title="{{ $item->title }}" subtitle="{{ $item->description }}">
                        <x-slot:figure>
                            <img src="{{ Storage::url($item->file_path) }}" alt="{{ $item->title }}" loading="lazy"
                                class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                        </x-slot:figure>
                    </x-mary-card>
                @endif
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-base-content/60">No photos found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
