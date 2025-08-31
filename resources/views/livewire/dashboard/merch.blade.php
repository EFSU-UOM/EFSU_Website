<?php

use App\Models\Merch;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination, WithFileUploads;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $deleteId = null;
    public $editId = null;
    
    // Form fields
    public $name = '';
    public $description = '';
    public $category = '';
    public $price = '';
    public $image = null;
    public $stock_quantity = '';
    public $is_available = true;

    public function mount()
    {
        //
    }

    public function getMerchProperty()
    {
        return Merch::latest()
            ->paginate(10);
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function openEditModal($id)
    {
        $merch = Merch::findOrFail($id);
        $this->editId = $id;
        $this->name = $merch->name;
        $this->description = $merch->description;
        $this->category = $merch->category;
        $this->price = $merch->price;
        $this->stock_quantity = $merch->stock_quantity;
        $this->is_available = $merch->is_available;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editId = null;
        $this->resetForm();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'is_available' => $this->is_available,
        ];

        if ($this->image) {
            $data['image_url'] = $this->image->store('merch', 'public');
        }

        Merch::create($data);

        $this->closeCreateModal();
        session()->flash('success', 'Merch item created successfully.');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $merch = Merch::findOrFail($this->editId);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'is_available' => $this->is_available,
        ];

        if ($this->image) {
            if ($merch->image_url) {
                Storage::disk('public')->delete($merch->image_url);
            }
            $data['image_url'] = $this->image->store('merch', 'public');
        }

        $merch->update($data);

        $this->closeEditModal();
        session()->flash('success', 'Merch item updated successfully.');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $merch = Merch::findOrFail($this->deleteId);
        
        if ($merch->image_url) {
            Storage::disk('public')->delete($merch->image_url);
        }

        $merch->delete();
        
        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'Merch item deleted successfully.');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->category = '';
        $this->price = '';
        $this->image = null;
        $this->stock_quantity = '';
        $this->is_available = true;
    }
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-base-content">Merch</h1>
                <p class="text-base-content/70 mt-1">Manage merchandise items for the portal</p>
            </div>
            <x-mary-button icon="o-plus" class="btn-primary" wire:click="openCreateModal">
                New Merch Item
            </x-mary-button>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <x-mary-alert title="Success!" description="{{ session('success') }}" icon="o-check-circle" class="alert-success" />
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <x-mary-icon name="o-shopping-bag" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Total</div>
                    <div class="stat-value text-primary">{{ $this->merch->total() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <x-mary-icon name="o-check-circle" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Available</div>
                    <div class="stat-value text-success">{{ $this->merch->where('is_available', true)->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <x-mary-icon name="o-archive-box" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">In Stock</div>
                    <div class="stat-value text-warning">{{ $this->merch->where('stock_quantity', '>', 0)->count() }}</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-error">
                        <x-mary-icon name="o-x-circle" class="w-8 h-8" />
                    </div>
                    <div class="stat-title">Out of Stock</div>
                    <div class="stat-value text-error">{{ $this->merch->where('stock_quantity', 0)->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Merch Table -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <x-mary-table :headers="[
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'category', 'label' => 'Category'],
                    ['key' => 'price', 'label' => 'Price'],
                    ['key' => 'stock_quantity', 'label' => 'Stock'],
                    ['key' => 'is_available', 'label' => 'Status'],
                    ['key' => 'actions', 'label' => 'Actions', 'sortable' => false]
                ]" :rows="$this->merch" with-pagination>
                    
                    @scope('cell_name', $merch)
                        <div>
                            <div class="font-semibold">{{ $merch->name }}</div>
                            <div class="text-sm opacity-70 truncate max-w-xs">{{ Str::limit($merch->description, 60) }}</div>
                        </div>
                    @endscope

                    @scope('cell_category', $merch)
                        <x-mary-badge 
                            :value="$merch->category" 
                            class="badge-ghost"
                        />
                    @endscope

                    @scope('cell_price', $merch)
                        <span class="font-semibold">Rs {{ number_format($merch->price, 2) }} /=</span>
                    @endscope

                    @scope('cell_stock_quantity', $merch)
                        <span class="{{ $merch->stock_quantity == 0 ? 'text-error' : 'text-base-content' }}">
                            {{ $merch->stock_quantity }}
                        </span>
                    @endscope

                    @scope('cell_is_available', $merch)
                        <x-mary-badge 
                            :value="$merch->is_available ? 'Available' : 'Unavailable'" 
                            class="{{ $merch->is_available ? 'badge-success' : 'badge-error' }}"
                        />
                    @endscope

                    @scope('cell_actions', $merch)
                        <div class="flex gap-2">
                            <x-mary-button 
                                icon="o-pencil" 
                                size="xs" 
                                class="btn-ghost"
                                wire:click="openEditModal({{ $merch->id }})"
                            />
                            <x-mary-button 
                                icon="o-trash" 
                                size="xs" 
                                class="btn-ghost text-error"
                                wire:click="confirmDelete({{ $merch->id }})"
                            />
                        </div>
                    @endscope
                </x-mary-table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <x-mary-modal wire:model="showCreateModal" title="Create Merch Item" class="backdrop-blur">
            <div class="grid gap-4">
                <x-mary-input wire:model="name" label="Name" required />
                <x-mary-textarea wire:model="description" label="Description" rows="4" required />
                <x-mary-input wire:model="category" label="Category" required />
                <x-mary-input wire:model="price" label="Price" type="number" step="0.01" required />
                <x-mary-input wire:model="stock_quantity" label="Stock Quantity" type="number" required />
                <x-mary-file wire:model="image" label="Image (optional)" accept="image/*" />
                <x-mary-checkbox wire:model="is_available" label="Available" />
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="closeCreateModal" />
                <x-mary-button label="Create" wire:click="store" class="btn-primary" />
            </x-slot:actions>
    </x-mary-modal>

    <!-- Edit Modal -->
    <x-mary-modal wire:model="showEditModal" title="Edit Merch Item" class="backdrop-blur">
            <div class="grid gap-4">
                <x-mary-input wire:model="name" label="Name" required />
                <x-mary-textarea wire:model="description" label="Description" rows="4" required />
                <x-mary-input wire:model="category" label="Category" required />
                <x-mary-input wire:model="price" label="Price" type="number" step="0.01" required />
                <x-mary-input wire:model="stock_quantity" label="Stock Quantity" type="number" required />
                <x-mary-file wire:model="image" label="Image (optional)" accept="image/*" />
                <x-mary-checkbox wire:model="is_available" label="Available" />
            </div>
            <x-slot:actions>
                <x-mary-button label="Cancel" wire:click="closeEditModal" />
                <x-mary-button label="Update" wire:click="update" class="btn-primary" />
            </x-slot:actions>
    </x-mary-modal>

    <!-- Delete Confirmation Modal -->
    <x-mary-modal wire:model="showDeleteModal" title="Delete Merch Item" class="backdrop-blur">
        <p>Are you sure you want to delete this merch item? This action cannot be undone.</p>
        <x-slot:actions>
            <x-mary-button label="Cancel" wire:click="$set('showDeleteModal', false)" />
            <x-mary-button label="Delete" wire:click="delete" class="btn-error" />
        </x-slot:actions>
    </x-mary-modal>
</div>