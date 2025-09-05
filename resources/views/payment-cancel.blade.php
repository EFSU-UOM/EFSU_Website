<x-layouts.public>
    <div class="min-h-screen bg-base-200 py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center">
                    <div class="mb-6">
                        <x-mary-icon name="o-x-circle" class="w-24 h-24 mx-auto text-warning mb-4" />
                        <h1 class="text-3xl font-bold text-warning mb-2">Payment Cancelled</h1>
                        <p class="text-base-content/70 mb-4">
                            Your payment was cancelled. No charges were made to your account.
                        </p>
                    </div>

                    @if (request()->has('order_id'))
                        <div class="bg-warning/10 border border-warning/20 rounded-lg p-4 mb-6">
                            <p class="font-semibold text-warning">Order ID: {{ request('order_id') }}</p>
                            <p class="text-sm text-base-content/70">
                                Your order is still pending. You can retry the payment anytime.
                            </p>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <x-mary-button label="Retry Payment" class="btn-primary" link="{{ route('checkout') }}" />
                        <x-mary-button label="Continue Shopping" class="btn-outline" link="{{ route('store') }}" />
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-xs text-base-content/60">
                            If you encountered any issues, please contact our support team.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
