<?php

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Mary\Traits\WithMediaSync;

new class extends Component {
    use WithFileUploads, WithMediaSync;
    
    public string $category = '';
    public string $complaint_text = '';
    public bool $is_anonymous = false;
    public Collection $library;
    public array $files = [];

    protected array $rules = [
        'category' => 'required|string|max:100',
        'complaint_text' => 'required|string|min:10',
        'is_anonymous' => 'boolean',
        'files' => 'nullable|array',
        'files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function mount()
    {
        $this->library = new Collection();
    }

    public function submit()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'category' => $this->category,
            'complaint_text' => $this->complaint_text,
            'is_anonymous' => $this->is_anonymous,
        ];

        if (!empty($this->files)) {
            $imagePaths = [];
            foreach ($this->files as $file) {
                $imagePaths[] = $file->store('complaint-images', 'public');
            }
            $data['images'] = $imagePaths;
        }

        Complaint::create($data);

        session()->flash('success', 'Your complaint has been submitted!');
        $this->reset();
        $this->library = new Collection();
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

            <x-mary-toggle
                label="Submit as anonymous"
                hint="Your identity will not be revealed when this option is enabled"
                wire:model="is_anonymous"
            />

            <div>
                <x-mary-image-library 
                    wire:model="files" 
                    wire:library="library" 
                    :preview="$library"
                    label="Upload images (optional)"
                    hint="You can upload multiple images to support your complaint"
                />
                @error('files')
                    <x-mary-alert type="error" flat class="py-1 text-sm">{{ $message }}</x-mary-alert>
                @enderror
                @error('files.*')
                    <x-mary-alert type="error" flat class="py-1 text-sm">{{ $message }}</x-mary-alert>
                @enderror
            </div>

            <div>
                <x-mary-button type="submit" color="primary" class="w-full">
                    Submit Complaint
                </x-mary-button>
            </div>
        </form>
    </x-mary-card>
</div>
