<?php

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $selectedStatus = '';
    public $search = '';
    public $showCreateForm = false;

    public function mount()
    {
        $this->search = request('search', '');
        $this->selectedStatus = request('status', '');
    }

    public function getComplaintsProperty()
    {
        $query = Complaint::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('category', 'like', "%{$this->search}%")
                    ->orWhere('complaint_text', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->selectedStatus)) {
            $query->where('status', $this->selectedStatus);
        }

        return $query->paginate(10);
    }

    public function openCreateForm()
    {
        $this->showCreateForm = true;
    }

    public function closeCreateForm()
    {
        $this->showCreateForm = false;
    }

    protected $listeners = ['complaint-submitted' => 'handleComplaintSubmitted'];

    public function handleComplaintSubmitted()
    {
        $this->showCreateForm = false;
        $this->resetPage(); // Refresh the complaints list
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedStatus']);
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
};
?>

<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-base-content">Complaints</h1>
            <p class="text-base-content/70 mt-1">Submit new complaints and track existing ones</p>
        </div>
        <x-mary-button wire:click="openCreateForm" class="btn-primary">
            <x-mary-icon name="o-plus" class="w-5 h-5" />
            Submit New Complaint
        </x-mary-button>
    </div>

    <!-- Create Complaint Modal -->
    <x-mary-modal wire:model="showCreateForm" title="Submit a Complaint" class="backdrop-blur" box-class="max-w-2xl">
        <livewire:create-complaint-form />
        
        <x-slot:actions>
            <x-mary-button label="Close" wire:click="closeCreateForm" />
        </x-slot:actions>
    </x-mary-modal>

    <!-- Filters -->
    <x-mary-card>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-mary-input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search complaints..." 
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

            <x-mary-button wire:click="clearFilters" class="btn-ghost">
                Clear Filters
            </x-mary-button>
        </div>
    </x-mary-card>

    <!-- Complaints List -->
    @if($this->complaints->count() > 0)
        <div class="space-y-4">
            @foreach($this->complaints as $complaint)
                <x-mary-card class="hover:shadow-lg transition-shadow">
                    <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                        <!-- Main Content -->
                        <div class="flex-1 space-y-3">
                            <!-- Header with Category and Status -->
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <x-mary-badge :value="ucwords(str_replace('_', ' ', $complaint->category))" class="badge-outline" />
                                    @if($complaint->is_anonymous)
                                        <x-mary-badge value="Anonymous" class="badge-ghost" />
                                    @endif
                                </div>
                                <x-mary-badge 
                                    :value="$complaint->formatted_status" 
                                    class="badge-{{ $complaint->status_badge_color }}"
                                />
                            </div>

                            <!-- Complaint Text -->
                            <div class="prose max-w-none">
                                <p class="text-base-content/90 leading-relaxed">
                                    {{ $complaint->complaint_text }}
                                </p>
                            </div>

                            <!-- Images -->
                            @if($complaint->images && count($complaint->images) > 0)
                                <div class="flex gap-2 flex-wrap">
                                    @foreach($complaint->images as $image)
                                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-base-200">
                                            <img 
                                                src="{{ Storage::url($image) }}" 
                                                alt="Complaint image" 
                                                class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-opacity"
                                                onclick="document.getElementById('modal_{{ $loop->parent->index }}_{{ $loop->index }}').showModal()"
                                            >
                                        </div>
                                        
                                        <!-- Image Modal -->
                                        <dialog id="modal_{{ $loop->parent->index }}_{{ $loop->index }}" class="modal">
                                            <div class="modal-box max-w-4xl">
                                                <img src="{{ Storage::url($image) }}" alt="Complaint image" class="w-full">
                                            </div>
                                            <form method="dialog" class="modal-backdrop">
                                                <button>close</button>
                                            </form>
                                        </dialog>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Metadata -->
                            <div class="flex items-center justify-between text-sm text-base-content/60 pt-2 border-t border-base-300">
                                <span>Submitted {{ $complaint->created_at->diffForHumans() }}</span>
                                <span>ID: #{{ $complaint->id }}</span>
                            </div>
                        </div>
                    </div>
                </x-mary-card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $this->complaints->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-mary-card class="text-center py-12">
            <div class="space-y-4">
                <x-mary-icon name="o-inbox" class="w-16 h-16 text-base-content/40 mx-auto" />
                <div>
                    <h3 class="text-xl font-semibold text-base-content">No complaints found</h3>
                    <p class="text-base-content/70 mt-1">
                        @if($search || $selectedStatus)
                            No complaints match your current filters.
                        @else
                            You haven't submitted any complaints yet.
                        @endif
                    </p>
                </div>
                @if($search || $selectedStatus)
                    <x-mary-button wire:click="clearFilters" class="btn-ghost">
                        Clear Filters
                    </x-mary-button>
                @else
                    <x-mary-button wire:click="openCreateForm" class="btn-primary">
                        Submit Your First Complaint
                    </x-mary-button>
                @endif
            </div>
        </x-mary-card>
    @endif
</div>