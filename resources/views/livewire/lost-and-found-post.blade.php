<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\LostAndFound;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public $postId;
    public $item;

    // Edit mode
    public $editMode = false;
    public $type = '';
    public $title = '';
    public $description = '';
    public $location = '';
    public $contact_info = '';
    public $item_date = '';
    public $status = '';
    public $image = null;

    protected $rules = [
        'type' => 'required|in:lost,found',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'nullable|string|max:255',
        'contact_info' => 'nullable|string|max:255',
        'item_date' => 'nullable|date',
        'status' => 'required|in:active,owner_found,lost_item_obtained',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->item = LostAndFound::with('user')->findOrFail($postId);
    }

    public function enableEdit()
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        $this->editMode = true;
        $this->type = $this->item->type;
        $this->title = $this->item->title;
        $this->description = $this->item->description;
        $this->location = $this->item->location;
        $this->contact_info = $this->item->contact_info;
        $this->item_date = $this->item->item_date ? $this->item->item_date->format('Y-m-d') : '';
        $this->status = $this->item->status;
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->image = null;
        $this->resetValidation();
    }

    public function update()
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        $this->validate();

        $data = [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'contact_info' => $this->contact_info,
            'item_date' => $this->item_date,
            'status' => $this->status,
        ];

        if ($this->image) {
            // Delete old image if exists
            if ($this->item->image) {
                Storage::disk('public')->delete($this->item->image);
            }

            $filename = time() . '_' . $this->image->getClientOriginalName();
            $path = $this->image->storeAs('lost-and-found', $filename, 'public');
            $data['image'] = $path;
        }

        $this->item->update($data);
        $this->item->refresh();
        $this->editMode = false;
        $this->image = null;

        session()->flash('success', 'Item updated successfully!');
    }

    public function updateStatus($status)
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        $this->item->update(['status' => $status]);
        $this->item->refresh();

        session()->flash('success', 'Status updated successfully!');
    }

    public function delete()
    {
        if (!auth()->check() || $this->item->user_id !== auth()->id()) {
            abort(403);
        }

        if ($this->item->image) {
            Storage::disk('public')->delete($this->item->image);
        }

        $this->item->delete();

        return redirect()->route('lost-and-found')->with('success', 'Item deleted successfully!');
    }
}; ?>


<section class="py-16">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center space-x-2 text-sm text-base-content/60">
                <a href="{{ route('lost-and-found') }}" class="hover:text-base-content">Lost & Found</a>
                <x-mary-icon name="o-chevron-right" class="w-4 h-4" />
                <span>{{ $item->title }}</span>
            </div>
        </div>

        <!-- Success Messages -->
        @if (session('success'))
        <x-mary-alert icon="o-check-circle" class="alert-success mb-6">
            {{ session('success') }}
        </x-mary-alert>
        @endif

        @if($editMode)
        <!-- Edit Form -->
        <x-mary-card class="bg-base-100 mb-6">
            <h2 class="text-2xl font-bold mb-6">Edit Post</h2>

            <form wire:submit.prevent="update" class="space-y-6">
                <!-- Item Type -->
                <div>
                    <x-mary-radio
                        wire:model="type"
                        :options="[
                                    ['id' => 'lost', 'name' => 'Lost Item - I lost something'],
                                    ['id' => 'found', 'name' => 'Found Item - I found something']
                                ]"
                        option-value="id"
                        option-label="name" />
                    @error('type') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Title -->
                <x-mary-input
                    wire:model="title"
                    label="Item Title"
                    placeholder="e.g., Black iPhone 14 Pro, Blue Backpack, etc." />
                @error('title') <span class="text-error text-sm">{{ $message }}</span> @enderror

                <!-- Description -->
                <x-mary-textarea
                    wire:model="description"
                    label="Description"
                    placeholder="Provide detailed description including color, brand, distinctive features, etc."
                    rows="4" />
                @error('description') <span class="text-error text-sm">{{ $message }}</span> @enderror

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Location -->
                    <div>
                        <x-mary-input
                            wire:model="location"
                            label="Location"
                            placeholder="Library, Cafeteria, etc." />
                        @error('location') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <x-mary-input
                            wire:model="item_date"
                            label="Date"
                            type="date" />
                        @error('item_date') <span class="text-error text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Contact Info -->
                <x-mary-input
                    wire:model="contact_info"
                    label="Contact Information (Optional)"
                    placeholder="Email, phone, or preferred contact method" />
                @error('contact_info') <span class="text-error text-sm">{{ $message }}</span> @enderror

                <!-- Status -->
                <x-mary-select
                    wire:model="status"
                    label="Status">
                    <option value="active">Active</option>
                    @if($type === 'lost')
                    <option value="owner_found">Owner Found</option>
                    @else
                    <option value="lost_item_obtained">Item Obtained</option>
                    @endif
                </x-mary-select>
                @error('status') <span class="text-error text-sm">{{ $message }}</span> @enderror

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-base-content mb-2">
                        {{ $item->image ? 'Update Photo' : 'Add Photo' }}
                    </label>
                    <input wire:model="image" type="file" accept="image/*" class="file-input file-input-bordered w-full" />
                    @error('image') <span class="text-error text-sm">{{ $message }}</span> @enderror

                    @if ($image)
                    <div class="mt-2">
                        <img src="{{ $image->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-4">
                    <x-mary-button type="button" class="btn-ghost" wire:click="cancelEdit">
                        Cancel
                    </x-mary-button>
                    <x-mary-button type="submit" class="btn-primary">
                        <x-mary-icon name="o-check" class="w-5 h-5" />
                        Update Item
                    </x-mary-button>
                </div>
            </form>
        </x-mary-card>
        @else
        <!-- Item Display -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image Section -->
            <div>
                @if($item->image)
                <div class="aspect-square bg-base-200 rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($item->image) }}"
                        alt="{{ $item->title }}"
                        class="w-full h-full object-cover">
                </div>
                @else
                <div class="aspect-square bg-base-200 rounded-lg flex items-center justify-center">
                    <div class="text-center">
                        <x-mary-icon name="o-photo" class="w-16 h-16 text-base-content/40 mx-auto mb-2" />
                        <p class="text-base-content/60">No image available</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="space-y-6">
                <!-- Type and Status Badges -->
                <div class="flex gap-3">
                    <x-mary-badge
                        :value="$item->type_label"
                        class="{{ $item->type === 'lost' ? 'badge-error badge-lg' : 'badge-success badge-lg' }}" />
                    <x-mary-badge
                        :value="$item->status_label"
                        class="{{ $item->status === 'active' ? 'badge-primary badge-lg' : 'badge-secondary badge-lg' }}" />
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-base-content">{{ $item->title }}</h1>

                <!-- User and Date Info -->
                <div class="flex items-center space-x-4 text-base-content/60">
                    <div class="flex items-center">
                        <x-mary-icon name="o-user" class="w-5 h-5 mr-2" />
                        <span>{{ $item->user->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <x-mary-icon name="o-clock" class="w-5 h-5 mr-2" />
                        <span>{{ $item->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-base-content mb-2">Description</h3>
                    <p class="text-base-content/80 leading-relaxed">{{ $item->description }}</p>
                </div>

                <!-- Additional Details -->
                <div class="space-y-4">
                    @if($item->location)
                    <div class="flex items-start">
                        <x-mary-icon name="o-map-pin" class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                        <div>
                            <p class="text-sm font-medium text-base-content/60">Location</p>
                            <p class="text-base-content">{{ $item->location }}</p>
                        </div>
                    </div>
                    @endif

                    @if($item->item_date)
                    <div class="flex items-start">
                        <x-mary-icon name="o-calendar-days" class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                        <div>
                            <p class="text-sm font-medium text-base-content/60">
                                {{ $item->type === 'lost' ? 'Date Lost' : 'Date Found' }}
                            </p>
                            <p class="text-base-content">{{ $item->item_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($item->contact_info)
                    <div class="flex items-start">
                        <x-mary-icon name="o-phone" class="w-5 h-5 text-base-content/60 mr-3 mt-0.5" />
                        <div>
                            <p class="text-sm font-medium text-base-content/60">Contact Info</p>
                            <p class="text-base-content">{{ $item->contact_info }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4 pt-6">
                    @auth
                    @if($item->user_id === auth()->id())
                    <!-- Owner Actions -->
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <x-mary-button
                                class="btn-secondary flex-1"
                                wire:click="enableEdit">
                                <x-mary-icon name="o-pencil" class="w-5 h-5" />
                                Edit Post
                            </x-mary-button>

                            <x-mary-button
                                class="btn-error flex-1"
                                wire:click="delete"
                                wire:confirm="Are you sure you want to delete this post?">
                                <x-mary-icon name="o-trash" class="w-5 h-5" />
                                Delete
                            </x-mary-button>
                        </div>

                        @if($item->status === 'active')
                        <!-- Status Update -->
                        <x-mary-card class="bg-base-200">
                            <h4 class="font-semibold text-base-content mb-3">Update Status</h4>
                            <div class="space-y-2">
                                @if($item->type === 'lost')
                                <x-mary-button
                                    class="btn-success w-full"
                                    wire:click="updateStatus('owner_found')">
                                    <x-mary-icon name="o-check-circle" class="w-5 h-5" />
                                    Mark as Found - Owner Located
                                </x-mary-button>
                                @else
                                <x-mary-button
                                    class="btn-success w-full"
                                    wire:click="updateStatus('lost_item_obtained')">
                                    <x-mary-icon name="o-check-circle" class="w-5 h-5" />
                                    Mark as Returned - Item Claimed
                                </x-mary-button>
                                @endif
                            </div>
                        </x-mary-card>
                        @endif
                    </div>
                    @else
                    <!-- Contact Owner -->
                    <div class="text-center">
                        <p class="text-base-content/70 mb-4">
                            @if($item->type === 'lost')
                            Have you found this item? Contact the owner to help them get it back.
                            @else
                            Is this your item? Contact the finder to claim it.
                            @endif
                        </p>
                        <x-mary-button class="btn-primary">
                            <x-mary-icon name="o-envelope" class="w-5 h-5" />
                            Contact {{ $item->user->name }}
                        </x-mary-button>
                        <p class="text-xs text-base-content/50 mt-2">
                            Contact functionality will be available soon
                        </p>
                    </div>
                    @endif
                    @else
                    <!-- Guest Actions -->
                    <div class="text-center">
                        <p class="text-base-content/70 mb-4">
                            <a href="{{ route('login') }}" class="link link-primary">Sign in</a>
                            to contact the {{ $item->type === 'lost' ? 'owner' : 'finder' }}
                        </p>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
        @endif

        <!-- Back to List -->
        <div class="mt-12 text-center">
            <x-mary-button link="{{ route('lost-and-found') }}" class="btn-ghost">
                <x-mary-icon name="o-arrow-left" class="w-5 h-5" />
                Back to Lost & Found
            </x-mary-button>
        </div>
    </div>
</section>