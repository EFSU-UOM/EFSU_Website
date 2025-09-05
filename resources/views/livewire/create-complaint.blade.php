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

<div class="container mx-auto px-4 py-8 md:py-12">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded border border-green-500 text-green-700">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 p-3 rounded border border-red-500 text-red-700">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Card --}}
    <div class="p-6 md:p-10 max-w-lg mx-auto border rounded">
        <h2 class="text-2xl font-bold text-center mb-6">
            Submit a Complaint
        </h2>

        <form wire:submit.prevent="submit" class="space-y-5">
            {{-- Category --}}
            <div>
                <label for="category" class="block font-medium mb-1">Category</label>
                <select id="category" wire:model="category"
                        class="w-full border rounded px-3 py-2"
                        required>
                    <option value="" disabled>Select a category</option>
                    <option value="canteen">Canteen / Food Services</option>
                    <option value="sports">Sports / Gym / Facilities</option>
                    <option value="library">Library / Study Resources</option>
                    <option value="hostel">Hostel / Accommodation</option>
                    <option value="transport">Transport / Parking</option>
                    <option value="faculty">Faculty / Teaching Issues</option>
                    <option value="administration">Administration / Office Services</option>
                    <option value="events">Events / Campus Activities</option>
                    <option value="safety">Safety / Security</option>
                    <option value="other">Other</option>
                </select>
                @error('category')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Complaint Text --}}
            <div>
                <label for="complaint_text" class="block font-medium mb-1">Complaint</label>
                <textarea id="complaint_text" wire:model="complaint_text"
                          rows="5"
                          placeholder="Type your complaint here..."
                          class="w-full border rounded px-3 py-2 resize-none"
                          required></textarea>
                @error('complaint_text')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Submit Complaint
                </button>
            </div>
        </form>
    </div>
</div>
