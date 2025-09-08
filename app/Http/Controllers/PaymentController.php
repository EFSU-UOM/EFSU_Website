<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function notify(Request $request)
    {
        // Log the notification for debugging
        Log::info('PayHere Notification', $request->all());
        
        $merchant_id = $request->input('merchant_id');
        $order_id = $request->input('order_id');
        $payhere_amount = $request->input('payhere_amount');
        $payhere_currency = $request->input('payhere_currency');
        $status_code = $request->input('status_code');
        $md5sig = $request->input('md5sig');
        $payment_id = $request->input('payment_id');
        $method = $request->input('method');
        
        // Find the order
        $order = Order::where('order_id', $order_id)->first();
        
        if (!$order) {
            Log::error('Order not found for PayHere notification', ['order_id' => $order_id]);
            return response('Order not found', 404);
        }
        
        // Verify the hash
        $merchant_secret = config('payhere.merchant_secret');
        if ($merchant_secret && $merchant_secret !== 'your_merchant_secret') {
            $local_md5sig = strtoupper(md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret))));
            
            if ($local_md5sig !== $md5sig) {
                Log::error('Invalid hash in PayHere notification', ['order_id' => $order_id, 'expected' => $local_md5sig, 'received' => $md5sig]);
                return response('Invalid hash', 400);
            }
        }
        
        // Update order status based on payment status
        if ($status_code == 2) { // Success
            $order->update([
                'status' => 'completed',
                'payment_id' => $payment_id,
                'payment_method' => $method,
                'paid_at' => now(),
            ]);
            
            // Clear user's cart
            Cart::where('user_id', $order->user_id)->delete();
            
            Log::info('Payment completed successfully', ['order_id' => $order_id]);
            
        } elseif ($status_code == 0) { // Pending
            $order->update(['status' => 'processing']);
            Log::info('Payment pending', ['order_id' => $order_id]);
            
        } elseif ($status_code == -1) { // Cancelled
            $order->update(['status' => 'cancelled']);
            Log::info('Payment cancelled', ['order_id' => $order_id]);
            
        } elseif ($status_code == -2) { // Failed
            $order->update(['status' => 'failed']);
            Log::info('Payment failed', ['order_id' => $order_id]);
            
        } elseif ($status_code == -3) { // Chargedback
            $order->update(['status' => 'failed']);
            Log::warning('Payment chargedback', ['order_id' => $order_id]);
        }
        
        return response('OK', 200);
    }
    
}
