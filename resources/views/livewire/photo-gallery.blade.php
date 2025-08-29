<?php

use App\Models\GalleryItem;
use function Livewire\Volt\{state, computed, mount};

state(['selectedCategory' => 'all']);

$galleryItems = computed(function() {
    $query = GalleryItem::query();
    
    if ($this->selectedCategory !== 'all') {
        $query->where('category', $this->selectedCategory);
    }
    
    return $query->latest()->get();
});

$setCategory = function($category) {
    $this->selectedCategory = $category;
};

?>

<!-- Gallery Categories -->
<section class="bg-base-200 py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-wrap justify-center gap-4">
            <x-mary-button 
                wire:click="setCategory('all')" 
                class="rounded-full {{ $selectedCategory === 'all' ? 'btn-primary' : 'btn-neutral' }}">
                All
            </x-mary-button>
            <x-mary-button 
                wire:click="setCategory('events')" 
                class="rounded-full {{ $selectedCategory === 'events' ? 'btn-primary' : 'btn-neutral' }}">
                Events
            </x-mary-button>
            <x-mary-button 
                wire:click="setCategory('seminars')" 
                class="rounded-full {{ $selectedCategory === 'seminars' ? 'btn-primary' : 'btn-neutral' }}">
                Seminars
            </x-mary-button>
            <x-mary-button 
                wire:click="setCategory('trips')" 
                class="rounded-full {{ $selectedCategory === 'trips' ? 'btn-primary' : 'btn-neutral' }}">
                Trips
            </x-mary-button>
            <x-mary-button 
                wire:click="setCategory('activities')" 
                class="rounded-full {{ $selectedCategory === 'activities' ? 'btn-primary' : 'btn-neutral' }}">
                Activities
            </x-mary-button>
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($this->galleryItems as $item)
                @if($item->link)
                    <a href="{{ $item->link }}" target="_blank" class="block">
                        <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl border-0" title="{{ $item->title }}" subtitle="{{ $item->description }}">
                            <x-slot:figure>
                            <img src="{{ $item->file_path }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                            </x-slot:figure>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                                <div class="p-4 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        <span class="text-sm">Click to view</span>
                                    </div>
                                </div>
                            </div>
                        </x-mary-card>
                    </a>
                @else
                    <x-mary-card class="group cursor-pointer relative overflow-hidden rounded-xl border-0" title="{{ $item->title }}" subtitle="{{ $item->description }}">
                        <x-slot:figure>
                        <img src="{{ $item->file_path }}"
                             alt="{{ $item->title }}"
                             class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                        </x-slot:figure>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-end">
                        </div>
                    </x-mary-card>
                @endif
            @endforeach
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <x-mary-button class="btn-primary" size="lg">
                Load More Photos
            </x-mary-button>
        </div>
    </div>
</section>