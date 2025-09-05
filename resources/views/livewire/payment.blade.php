<?php

use App\Models\Order;
use function Livewire\Volt\{state, mount};

state(['order']);

mount(function ($orderId) {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    $order = Order::with('orderItems.merch')->find($orderId);
    
    if (!$order || $order->user_id !== auth()->id()) {
        abort(404);
    }
    
    $this->order = $order;
});

$generatePayHereHash = function () {
    $merchant_id = config('payhere.merchant_id');
    $merchant_secret = config('payhere.merchant_secret');
    
    $order_id = $this->order->order_id;
    $amount = number_format($this->order->total_amount, 2, '.', '');
    $currency = $this->order->currency;
    
    $hash = strtoupper(
        md5(
            $merchant_id . 
            $order_id . 
            $amount . 
            $currency .  
            strtoupper(md5($merchant_secret)) 
        ) 
    );
    
    return $hash;
};

$getItemsList = function () {
    return $this->order->orderItems->map(function ($item) {
        return $item->merch->name . ' x' . $item->quantity;
    })->join(', ');
};

$getPayHereUrl = function () {
    return config('payhere.sandbox') 
        ? config('payhere.urls.sandbox') 
        : config('payhere.urls.production');
};

?>

<div class="min-h-screen bg-base-200 py-8">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <x-mary-header title="Payment" subtitle="Complete your order with secure payment">
            <x-slot:actions>
                <x-mary-button label="Back to Checkout" class="btn-outline" link="{{ route('checkout') }}" />
            </x-slot:actions>
        </x-mary-header>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">Order Details</h2>
                
                <!-- Order Summary -->
                <div class="bg-base-200 p-4 rounded-lg mb-6">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="font-semibold">Order ID:</p>
                            <p>{{ $this->order->order_id }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Total Amount:</p>
                            <p class="text-primary font-bold">LKR {{ number_format($this->order->total_amount, 0) }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="font-semibold">Items:</p>
                            <p>{{ $this->getItemsList() }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Customer:</p>
                            <p>{{ $this->order->first_name }} {{ $this->order->last_name }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Email:</p>
                            <p>{{ $this->order->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- PayHere Payment Form -->
                <div class="text-center">                    
                    <form method="post" action="{{ $this->getPayHereUrl() }}" class="space-y-0">
                        <!-- PayHere Configuration -->
                        <input type="hidden" name="merchant_id" value="{{ config('payhere.merchant_id') }}">
                        <input type="hidden" name="return_url" value="{{ config('payhere.callback_urls.return') }}">
                        <input type="hidden" name="cancel_url" value="{{ config('payhere.callback_urls.cancel') }}">
                        <input type="hidden" name="notify_url" value="{{ config('payhere.callback_urls.notify') }}">
                        
                        <!-- Order Details -->
                        <input type="hidden" name="order_id" value="{{ $this->order->order_id }}">
                        <input type="hidden" name="items" value="{{ $this->getItemsList() }}">
                        <input type="hidden" name="currency" value="{{ $this->order->currency }}">
                        <input type="hidden" name="amount" value="{{ number_format($this->order->total_amount, 2, '.', '') }}">
                        
                        <!-- Customer Details -->
                        <input type="hidden" name="first_name" value="{{ $this->order->first_name }}">
                        <input type="hidden" name="last_name" value="{{ $this->order->last_name }}">
                        <input type="hidden" name="email" value="{{ $this->order->email }}">
                        <input type="hidden" name="phone" value="{{ $this->order->phone }}">
                        <input type="hidden" name="address" value="{{ $this->order->address }}">
                        <input type="hidden" name="city" value="{{ $this->order->city }}">
                        <input type="hidden" name="country" value="{{ $this->order->country }}">
                        
                        <!-- Security Hash -->
                        <input type="hidden" name="hash" value="{{ $this->generatePayHereHash() }}">
                        
                        <!-- Payment Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-full">
                            <x-mary-icon name="o-credit-card" class="w-5 h-5 mr-2" />
                            Pay LKR {{ number_format($this->order->total_amount, 0) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Order Items Details -->
        <div class="card bg-base-100 shadow-xl mt-6">
            <div class="card-body">
                <h3 class="card-title mb-4">Order Items</h3>
                <div class="space-y-3">
                    @foreach($this->order->orderItems as $item)
                        <div class="flex items-center gap-4 p-3 bg-base-200 rounded-lg">
                            <div class="avatar">
                                <div class="w-16 h-16 rounded">
                                    <img src="{{ $item->merch->image_url ?: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab' }}" 
                                         alt="{{ $item->merch->name }}" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold">{{ $item->merch->name }}</h4>
                                <p class="text-sm text-base-content/70">{{ $item->merch->category->label() }}</p>
                                <p class="text-sm">LKR {{ number_format($item->unit_price, 0) }} each</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">{{ $item->quantity }}x</p>
                                <p class="font-bold text-primary">LKR {{ number_format($item->total_price, 0) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>