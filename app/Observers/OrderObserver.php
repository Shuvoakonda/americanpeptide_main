<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Services\OrderEmailService;

class OrderObserver
{
    public function created(Order $order)
    {
        OrderHistory::create([
            'order_id' => $order->id,
            'event' => 'created',
            'description' => 'Order was created.',
            'old_value' => null,
            'new_value' => $order->toArray(),
        ]);
    }

    public function updated(Order $order)
    {
        $orderEmailService = app()->make(OrderEmailService::class);

        // Status change
        $originalStatus = $order->getOriginal('status');
        if ($originalStatus !== $order->status) {
            $orderEmailService->sendOrderStatusUpdate($order, $originalStatus, $order->status);
            OrderHistory::create([
                'order_id' => $order->id,
                'event' => 'status_changed',
                'old_value' => ['status' => $originalStatus],
                'new_value' => ['status' => $order->status],
                'description' => "Order status changed from $originalStatus to {$order->status}.",
            ]);

            // Grant audiobook access if order is now paid or completed
            if (in_array($order->status, ['paid', 'completed']) && $order->user) {
                foreach ($order->lines as $line) {
                    $product = $line->product;
                    if ($product) {
                        foreach ($product->audioBooks as $audioBook) {
                            $order->user->audioBooks()->syncWithoutDetaching([
                                $audioBook->id => ['unlocked_at' => now()]
                            ]);
                        }
                    }
                }
            }
        }

        // Shipping method change
        $originalShipping = $order->getOriginal('shipping_method');
        if ($originalShipping !== $order->shipping_method && !empty($order->shipping_method)) {
            $orderEmailService->sendShippingConfirmation($order);
            OrderHistory::create([
                'order_id' => $order->id,
                'event' => 'shipping_method_changed',
                'old_value' => ['shipping_method' => $originalShipping],
                'new_value' => ['shipping_method' => $order->shipping_method],
                'description' => "Shipping method changed from $originalShipping to {$order->shipping_method}.",
            ]);
        }
    }
} 