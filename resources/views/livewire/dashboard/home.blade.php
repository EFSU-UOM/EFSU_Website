<?php

use App\Models\Complaint;
use App\Models\LostAndFound;
use App\Models\Order;
use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'pendingComplaints' => Complaint::where('status', 'delivered')->count(),
            'totalUsers' => User::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'activeLostAndFound' => LostAndFound::active()->count(),
        ];
    }
}; ?>

<div class="space-y-6">
    <x-mary-header title="Dashboard" subtitle="Overview of the EFSU Portal" separator />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-mary-stat title="Pending Complaints" :value="$pendingComplaints" icon="o-exclamation-triangle" class="bg-base-100 border border-base-300 rounded-xl" />
        <x-mary-stat title="Total Users" :value="$totalUsers" icon="o-users" class="bg-base-100 border border-base-300 rounded-xl" />
        <x-mary-stat title="Pending Orders" :value="$pendingOrders" icon="o-shopping-bag" class="bg-base-100 border border-base-300 rounded-xl" />
        <x-mary-stat title="Active Lost & Found" :value="$activeLostAndFound" icon="o-magnifying-glass" class="bg-base-100 border border-base-300 rounded-xl" />
    </div>
</div>
