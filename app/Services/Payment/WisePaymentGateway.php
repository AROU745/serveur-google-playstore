<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;

class WisePaymentGateway implements PaymentGatewayInterface
{
    public function getIdentifier(): string
    {
        return Payment::METHOD_WISE;
    }

    public function isAvailable(): bool
    {
        return filled(config('services.wise.payment_url'));
    }

    public function initiate(Order $order): array
    {
        $url = config('services.wise.payment_url');

        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => Payment::METHOD_WISE,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'status' => Payment::STATUS_AWAITING,
            'metadata' => [
                'description' => config('services.plan.description'),
                'redirect_prepared' => filled($url),
            ],
        ]);

        $order->update([
            'payment_method' => Payment::METHOD_WISE,
            'status' => Order::STATUS_AWAITING,
        ]);

        return [
            'payment' => $payment,
            'redirect_url' => $url,
            'amount' => (float) $order->amount,
            'currency' => $order->currency,
            'description' => config('services.plan.description'),
        ];
    }
}
