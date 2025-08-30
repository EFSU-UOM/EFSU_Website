<?php

use App\Models\Merch;
use function Livewire\Volt\{state, computed};

state(['selectedCategory' => '']);

$filteredMerch = computed(function () {
    $query = Merch::where('is_available', true);
    
    if ($this->selectedCategory) {
        $query->where('category', $this->selectedCategory);
    }
    
    return $query->orderBy('name')->get();
});

?>

<section class="bg-base-200 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <x-mary-header title="Union Merchandise" subtitle="Show your EFSU pride with our official merchandise collection">
        <x-slot:actions>
            <x-mary-select
                        wire:model.live="selectedCategory"
                        class="w-48"
                        :options="[
                            ['name' => 'All Categories', 'id' => ''],
                            ['name' => 'T-Shirts', 'id' => 'tshirts'],
                            ['name' => 'Caps', 'id' => 'caps'],
                            ['name' => 'Wrist Bands', 'id' => 'wristbands'],
                            ['name' => 'Stickers', 'id' => 'stickers'],
                        ]"
                    />
        </x-slot:actions>
    </x-mary-header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($this->filteredMerch as $item)
                <x-mary-card class="shadow-sm hover:shadow-md transition-shadow overflow-hidden bg-base-100 max-w-sm mx-auto">
                    <x-slot name="figure">
                        <img src="{{ $item->image_url ?: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                            alt="{{ $item->name }}" class="w-full h-48 object-cover">
                    </x-slot>

                    <div class="">
                        <div class="flex items-center justify-between mb-2">
                            <x-mary-badge value="{{ ucfirst($item->category) }}" class="badge-outline" />
                            @if($item->stock_quantity <= 5 && $item->stock_quantity > 0)
                                <x-mary-badge value="Low Stock" class="badge-warning" />
                            @elseif($item->stock_quantity === 0)
                                <x-mary-badge value="Out of Stock" class="badge-error" />
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">{{ $item->name }}</h3>
                        <p class="text-base-content/70 mb-4">{{ $item->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-primary">LKR {{ number_format($item->price, 0) }}</span>
                            @if($item->is_available && $item->stock_quantity > 0)
                                <x-mary-button label="Order Now" class="btn-primary btn-sm" />
                            @else
                                <x-mary-button label="Unavailable" class="btn-disabled btn-sm" disabled />
                            @endif
                        </div>
                        @if($item->stock_quantity > 0)
                            <div class="mt-2">
                                <span class="text-xs text-base-content/60">{{ $item->stock_quantity }} in stock</span>
                            </div>
                        @endif
                    </div>
                </x-mary-card>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-base-content/60">
                        @if($selectedCategory)
                            No {{ $selectedCategory }} available at the moment.
                        @else
                            No merchandise available at the moment.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        {{-- <div class="flex justify-center mt-12">
            <x-mary-pagination :links="[
                ['label' => 'Previous', 'url' => '#', 'active' => false],
                ['label' => '1', 'url' => '#', 'active' => true],
                ['label' => '2', 'url' => '#', 'active' => false],
                ['label' => '3', 'url' => '#', 'active' => false],
                ['label' => 'Next', 'url' => '#', 'active' => false],
            ]" />
        </div> --}}
    </div>
</section>