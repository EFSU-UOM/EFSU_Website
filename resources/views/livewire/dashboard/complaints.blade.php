<?php

use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $selectedStatus = '';
    public $selectedCategory = '';
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->search = request('search', '');
        $this->selectedStatus = request('status', '');
        $this->selectedCategory = request('category', '');
    }

    public function with()
    {
        return [
            'complaints' => $this->getComplaintsProperty(),
        ];
    }

    public function getComplaintsProperty()
    {
        $query = Complaint::with('user')
            ->orderBy($this->sortBy, $this->sortDirection);

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('category', 'like', $searchTerm)
                    ->orWhere('complaint_text', 'like', $searchTerm)
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', $searchTerm)
                            ->orWhere('email', 'like', $searchTerm);
                    });
            });
        }

        if (!empty($this->selectedStatus)) {
            $query->where('status', $this->selectedStatus);
        }

        if (!empty($this->selectedCategory)) {
            $query->where('category', $this->selectedCategory);
        }

        return $query->paginate(15);
    }

    public function updateStatus($complaintId, $status)
    {
        $complaint = Complaint::findOrFail($complaintId);
        $complaint->update(['status' => $status]);
        
        $this->dispatch('complaint-status-updated');
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedStatus', 'selectedCategory']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }
};
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-base-content">Complaints Management</h1>
            <p class="text-base-content/70 mt-1">Manage and respond to user complaints</p>
        </div>
        <div class="flex items-center gap-2">
            <x-mary-badge value="{{ $complaints->total() }} Total" class="badge-neutral" />
        </div>
    </div>

    <!-- Filters -->
    <x-mary-card>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-mary-input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search complaints, users..." 
                icon="o-magnifying-glass" 
            />
            
            <x-mary-select 
                wire:model.live="selectedStatus" 
                placeholder="Filter by status"
                :options="[
                    ['name' => 'Delivered', 'id' => 'delivered'],
                    ['name' => 'Viewed', 'id' => 'viewed'],
                    ['name' => 'In Progress', 'id' => 'in_progress'],
                    ['name' => 'Action Taken', 'id' => 'action_taken'],
                    ['name' => 'Rejected', 'id' => 'rejected'],
                    ['name' => 'Incomplete', 'id' => 'incomplete'],
                ]"
            />

            <x-mary-select 
                wire:model.live="selectedCategory" 
                placeholder="Filter by category"
                :options="[
                    ['name' => 'Academic Issues', 'id' => 'academic_issues'],
                    ['name' => 'Infrastructure', 'id' => 'infrastructure'],
                    ['name' => 'Food Services', 'id' => 'food_services'],
                    ['name' => 'Transportation', 'id' => 'transportation'],
                    ['name' => 'Events', 'id' => 'events'],
                    ['name' => 'Other', 'id' => 'other'],
                ]"
            />

            <x-mary-button wire:click="clearFilters" class="btn-ghost">
                Clear Filters
            </x-mary-button>
        </div>
    </x-mary-card>

    <!-- Complaints Table -->
    @if($complaints->count() > 0)
        <x-mary-card>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>
                                <button wire:click="sortBy('id')" class="flex items-center gap-1 hover:text-primary">
                                    ID
                                    @if($sortBy === 'id')
                                        <x-mary-icon name="{{ $sortDirection === 'asc' ? 'o-chevron-up' : 'o-chevron-down' }}" class="w-4 h-4" />
                                    @endif
                                </button>
                            </th>
                            <th>User</th>
                            <th>Category</th>
                            <th>Complaint</th>
                            <th>Status</th>
                            <th>
                                <button wire:click="sortBy('created_at')" class="flex items-center gap-1 hover:text-primary">
                                    Date
                                    @if($sortBy === 'created_at')
                                        <x-mary-icon name="{{ $sortDirection === 'asc' ? 'o-chevron-up' : 'o-chevron-down' }}" class="w-4 h-4" />
                                    @endif
                                </button>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaints as $complaint)
                            <tr>
                                <td class="font-mono text-sm">#{{ $complaint->id }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold text-xs">
                                            @if($complaint->is_anonymous)
                                                ?
                                            @else
                                                {{ $complaint->user->initials() }}
                                            @endif
                                        </div>
                                        <div>
                                            @if($complaint->is_anonymous)
                                                <div class="font-semibold text-sm">Anonymous</div>
                                                <div class="text-xs opacity-70">Hidden</div>
                                            @else
                                                <div class="font-semibold text-sm">{{ $complaint->user->name }}</div>
                                                <div class="text-xs opacity-70">{{ $complaint->user->email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <x-mary-badge 
                                        :value="ucwords(str_replace('_', ' ', $complaint->category))" 
                                        class="badge-outline badge-sm" 
                                    />
                                </td>
                                <td>
                                    <div class="max-w-xs">
                                        <p class="text-sm text-base-content/90 line-clamp-2">
                                            {{ Str::limit($complaint->complaint_text, 100) }}
                                        </p>
                                        @if($complaint->images && count($complaint->images) > 0)
                                            <div class="flex items-center gap-1 mt-1">
                                                <x-mary-icon name="o-photo" class="w-3 h-3 opacity-60" />
                                                <span class="text-xs opacity-60">{{ count($complaint->images) }} image(s)</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <x-mary-select 
                                        wire:change="updateStatus({{ $complaint->id }}, $event.target.value)"
                                        value="{{ $complaint->status }}"
                                        class="select-sm"
                                        :options="[
                                            ['name' => 'Delivered', 'id' => 'delivered'],
                                            ['name' => 'Viewed', 'id' => 'viewed'],
                                            ['name' => 'In Progress', 'id' => 'in_progress'],
                                            ['name' => 'Action Taken', 'id' => 'action_taken'],
                                            ['name' => 'Rejected', 'id' => 'rejected'],
                                            ['name' => 'Incomplete', 'id' => 'incomplete'],
                                        ]"
                                    />
                                </td>
                                <td>
                                    <div class="text-sm">
                                        <div>{{ $complaint->created_at->format('M d, Y') }}</div>
                                        <div class="opacity-60">{{ $complaint->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <x-mary-button 
                                            class="btn-ghost btn-sm" 
                                            onclick="viewComplaint{{ $complaint->id }}.showModal()"
                                        >
                                            <x-mary-icon name="o-eye" class="w-4 h-4" />
                                        </x-mary-button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Complaint Detail Modal -->
                            <dialog id="viewComplaint{{ $complaint->id }}" class="modal">
                                <div class="modal-box max-w-2xl">
                                    <h3 class="font-bold text-lg mb-4">Complaint Details #{{ $complaint->id }}</h3>
                                    
                                    <!-- User Info -->
                                    <div class="bg-base-200 p-4 rounded-lg mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold">
                                                @if($complaint->is_anonymous)
                                                    ?
                                                @else
                                                    {{ $complaint->user->initials() }}
                                                @endif
                                            </div>
                                            <div>
                                                @if($complaint->is_anonymous)
                                                    <div class="font-semibold">Anonymous User</div>
                                                    <div class="text-sm opacity-70">Identity hidden</div>
                                                @else
                                                    <div class="font-semibold">{{ $complaint->user->name }}</div>
                                                    <div class="text-sm opacity-70">{{ $complaint->user->email }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Complaint Content -->
                                    <div class="space-y-4">
                                        <div>
                                            <label class="font-semibold text-sm opacity-70">Category</label>
                                            <div class="mt-1">
                                                <x-mary-badge :value="ucwords(str_replace('_', ' ', $complaint->category))" class="badge-outline" />
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-semibold text-sm opacity-70">Status</label>
                                            <div class="mt-1">
                                                <x-mary-badge 
                                                    :value="$complaint->formatted_status" 
                                                    class="badge-{{ $complaint->status_badge_color }}"
                                                />
                                            </div>
                                        </div>

                                        <div>
                                            <label class="font-semibold text-sm opacity-70">Complaint Text</label>
                                            <div class="mt-1 p-3 bg-base-200 rounded-lg">
                                                <p class="text-sm leading-relaxed">{{ $complaint->complaint_text }}</p>
                                            </div>
                                        </div>

                                        @if($complaint->images && count($complaint->images) > 0)
                                            <div>
                                                <label class="font-semibold text-sm opacity-70">Attachments</label>
                                                <div class="mt-2 grid grid-cols-3 gap-2">
                                                    @foreach($complaint->images as $image)
                                                        <div class="aspect-square rounded-lg overflow-hidden bg-base-200">
                                                            <img 
                                                                src="{{ Storage::url($image) }}" 
                                                                alt="Complaint image" 
                                                                class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                                                                onclick="imageModal{{ $complaint->id }}_{{ $loop->index }}.showModal()"
                                                            >
                                                        </div>

                                                        <!-- Image Modal -->
                                                        <dialog id="imageModal{{ $complaint->id }}_{{ $loop->index }}" class="modal">
                                                            <div class="modal-box max-w-4xl">
                                                                <img src="{{ Storage::url($image) }}" alt="Complaint image" class="w-full">
                                                            </div>
                                                            <form method="dialog" class="modal-backdrop">
                                                                <button>close</button>
                                                            </form>
                                                        </dialog>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                                            <div>
                                                <label class="font-semibold text-sm opacity-70">Submitted</label>
                                                <div class="text-sm">{{ $complaint->created_at->format('M d, Y H:i') }}</div>
                                            </div>
                                            <div>
                                                <label class="font-semibold text-sm opacity-70">Last Updated</label>
                                                <div class="text-sm">{{ $complaint->updated_at->format('M d, Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-action">
                                        <form method="dialog">
                                            <button type="button" class="btn" onclick="this.closest('dialog').close()">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-mary-card>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $complaints->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-mary-card class="text-center py-12">
            <div class="space-y-4">
                <x-mary-icon name="o-inbox" class="w-16 h-16 text-base-content/40 mx-auto" />
                <div>
                    <h3 class="text-xl font-semibold text-base-content">No complaints found</h3>
                    <p class="text-base-content/70 mt-1">
                        @if($search || $selectedStatus || $selectedCategory)
                            No complaints match your current filters.
                        @else
                            No complaints have been submitted yet.
                        @endif
                    </p>
                </div>
                @if($search || $selectedStatus || $selectedCategory)
                    <x-mary-button wire:click="clearFilters" class="btn-ghost">
                        Clear Filters
                    </x-mary-button>
                @endif
            </div>
        </x-mary-card>
    @endif
</div>