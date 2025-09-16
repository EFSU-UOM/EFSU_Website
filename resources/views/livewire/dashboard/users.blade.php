<?php

use App\Enums\AccessLevel;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Volt\Component;

new class extends Component {
    use WithPagination;

    public string $search = '';
    public string $accessLevelFilter = '';
    public bool $showModal = false;
    public ?User $selectedUser = null;
    public int $newAccessLevel = AccessLevel::USER->value;

    public function mount()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedAccessLevelFilter()
    {
        $this->resetPage();
    }

    #[Computed]
    public function users()
    {
        $query = User::query();

        // Hide super admins from the list
        $query->where('access_level', '>', 0);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', "%{$this->search}%")->orWhere('email', 'LIKE', "%{$this->search}%");
            });
        }

        if ($this->accessLevelFilter) {
            $query->where('access_level', $this->accessLevelFilter);
        }

        return $query->orderBy('name')->paginate(15);
    }

    #[Computed]
    public function accessLevels()
    {
        // Exclude Super Admin from filter options
        return collect(AccessLevel::cases())->filter(fn($level) => $level->value > 0)->values();
    }

    #[Computed]
    public function availableAccessLevels()
    {
        $currentUser = auth()->user();
        return collect(AccessLevel::cases())->filter(fn($level) => $level->value >= $currentUser->access_level->value)->values();
    }

    public function openModal(User $user)
    {
        // Prevent users from editing their own access level
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot change your own access level.');
            return;
        }

        $this->selectedUser = $user;
        $this->newAccessLevel = $user->access_level->value;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedUser = null;
        $this->newAccessLevel = AccessLevel::USER->value;
    }

    public function updateAccessLevel()
    {
        if (!$this->selectedUser) {
            return;
        }

        $currentUser = auth()->user();

        // Prevent users from editing their own access level
        if ($this->selectedUser->id === $currentUser->id) {
            $this->addError('newAccessLevel', 'You cannot change your own access level.');
            return;
        }

        // Validate that user can only set access levels at their level or lower
        if ($this->newAccessLevel < $currentUser->access_level->value) {
            $this->addError('newAccessLevel', 'You can only assign access levels at your level or lower.');
            return;
        }

        $this->selectedUser->access_level = $this->newAccessLevel;
        $this->selectedUser->save();

        $this->closeModal();

        session()->flash('message', 'User access level updated successfully!');
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->accessLevelFilter = '';
        $this->resetPage();
    }
}; ?>


<div class="flex h-full w-full flex-1 flex-col gap-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">User Management</h1>
            <p class="text-muted-foreground">Manage user access levels and permissions</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col gap-4 p-4 bg-base-200 rounded-lg">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <x-mary-input wire:model.live.debounce.300ms="search" placeholder="Search by name or email..."
                    icon="o-magnifying-glass" clearable />
            </div>

            <!-- Access Level Filter -->
            <div class="w-full md:w-48">
                <x-mary-select wire:model.live="accessLevelFilter" placeholder="Filter by access level"
                    :options="collect($this->accessLevels)->map(
                        fn($level) => ['value' => $level->value, 'name' => $level->label()],
                    )" option-value="value" option-label="name" />
            </div>

            <!-- Clear Filters -->
            <x-mary-button wire:click="clearFilters" icon="o-x-mark" class="btn-outline">
                Clear
            </x-mary-button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-base-100 rounded-lg border">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Access Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->users as $user)
                        <tr class="hover:bg-base-200">
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold text-sm">
                                        {{ $user->initials() }}
                                    </div>
                                    <div>
                                        <div class="font-semibold">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact ?? 'N/A' }}</td>
                            <td>
                                <x-mary-badge :value="$user->getAccessLevelLabel()"
                                    class="{{ $user->access_level->value === 1000 ? 'badge-neutral' : ($user->access_level->value <= 1 ? 'badge-error' : ($user->access_level->value <= 10 ? 'badge-warning' : 'badge-success')) }}" />
                            </td>
                            <td>
                                @if($user->id === auth()->id())
                                    <x-mary-button icon="o-lock-closed" class="btn-sm btn-ghost" disabled tooltip="Cannot edit your own access level" />
                                @else
                                    <x-mary-button wire:click="openModal({{ $user->id }})" icon="o-pencil"
                                        class="btn-sm btn-ghost" tooltip="Edit User" />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-muted-foreground">
                                No users found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t">
            {{ $this->users->links() }}
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <x-mary-alert icon="o-check-circle" class="alert-success">
            {{ session('message') }}
        </x-mary-alert>
    @endif

    <!-- Error Message -->
    @if (session()->has('error'))
        <x-mary-alert icon="o-exclamation-triangle" class="alert-error">
            {{ session('error') }}
        </x-mary-alert>
    @endif

    <!-- User Edit Modal -->
    <x-mary-modal wire:model="showModal" title="Edit User" subtitle="Update user access level" class="backdrop-blur">
        @if ($selectedUser)
            <div class="py-4">
                <!-- User Info -->
                <div class="flex items-center space-x-4 mb-6 p-4 bg-base-200 rounded-lg">
                    <div
                        class="w-12 h-12 rounded-full bg-primary text-primary-content flex items-center justify-center font-semibold">
                        {{ $selectedUser->initials() }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">{{ $selectedUser->name }}</h3>
                        <p class="text-sm opacity-70">{{ $selectedUser->email }}</p>
                        <p class="text-sm opacity-70">Contact: {{ $selectedUser->contact ?? 'N/A' }}</p>
                        <p class="text-sm opacity-70">Current Access: {{ $selectedUser->getAccessLevelLabel() }}</p>
                    </div>
                </div>

                <!-- Access Level Selection -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">New Access Level</span>
                    </label>
                    <x-mary-select wire:model="newAccessLevel" :options="$this->availableAccessLevels->map(
                        fn($level) => ['value' => $level->value, 'name' => $level->label()],
                    )" option-value="value"
                        option-label="name" placeholder="Select access level" class="select-bordered" />
                    @error('newAccessLevel')
                        <div class="text-error text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info mt-4">
                    <x-mary-icon name="o-information-circle" />
                    <span>You can only assign access levels at your level or lower
                        ({{ auth()->user()->getAccessLevelLabel() }}).</span>
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.closeModal()" />
                <x-mary-button label="Update" class="btn-primary" wire:click="updateAccessLevel" />
            </x-slot:actions>
        @endif
    </x-mary-modal>
</div>
