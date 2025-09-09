<?php

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $category = '';
    public string $complaint_text = '';

    protected array $rules = [
        'category' => 'required|string|max:100',
        'complaint_text' => 'required|string|min:10',
    ];

    public function submit()
    {
        $this->validate();

        Complaint::create([
            'user_id' => Auth::id(),
            'category' => $this->category,
            'complaint_text' => $this->complaint_text,
        ]);

        session()->flash('success', 'Your complaint has been submitted!');
        $this->reset();
    }
};
?>

<div class="max-w-xl mx-auto px-4 py-10 space-y-6">

    @if(session('success'))
        <x-mary-alert type="success" icon="o-check-circle" dismissible>
            {{ session('success') }}
        </x-mary-alert>
    @endif

    @if(session('error'))
        <x-mary-alert type="error" icon="o-exclamation-circle" dismissible>
            {{ session('error') }}
        </x-mary-alert>
    @endif

    <x-mary-card>
        <x-slot name="header">
            <h2 class="text-2xl font-semibold">Submit a Complaint</h2>
        </x-slot>

        <form wire:submit.prevent="submit" class="space-y-5">

            <x-mary-select
                label="Category"
                wire:model.live="category"
                class="w-48"
                placeholder="Select a category"
                :options="[
                    ['name' => 'Canteen / Food Services', 'id' => 'canteen'],
                    ['name' => 'Sports / Gym / Facilities', 'id' => 'sports'],
                    ['name' => 'Library / Study Resources', 'id' => 'library'],
                    ['name' => 'Hostel / Accommodation', 'id' => 'hostel'],
                    ['name' => 'Transport / Parking', 'id' => 'transport'],
                    ['name' => 'Faculty / Teaching Issues', 'id' => 'faculty'],
                    ['name' => 'Administration / Office Services', 'id' => 'administration'],
                    ['name' => 'Events / Campus Activities', 'id' => 'events'],
                    ['name' => 'Safety / Security', 'id' => 'safety'],
                    ['name' => 'Other', 'id' => 'other'],
                ]"
                required
            />
            @error('category')
                <x-mary-alert type="error" flat class="py-1 text-sm">{{ $message }}</x-mary-alert>
            @enderror

            <x-mary-textarea
                label="Complaint"
                wire:model="complaint_text"
                rows="5"
                placeholder="Type your complaint here..."
                required
            />
            @error('complaint_text')
                <x-mary-alert type="error" flat class="py-1 text-sm">{{ $message }}</x-mary-alert>
            @enderror

            <div>
                <x-mary-button type="submit" color="primary" class="w-full">
                    Submit Complaint
                </x-mary-button>
            </div>
        </form>
    </x-mary-card>
</div>
