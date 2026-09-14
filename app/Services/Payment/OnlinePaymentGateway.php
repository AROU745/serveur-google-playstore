<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use RuntimeException;

/**
 * Architecture prête pour Visa / Mobile Money / IBAN européen.
 * Les clés secrètes restent côté serveur uniquement.
 */
class OnlinePaymentGateway implements PaymentGatewayInterface
{
    public function getIdentifier(): string
    {
        return Payment::METHOD_ONLINE;
    }

    public function isAvailable(): bool
    {
        return (bool) config('services.online_payment.enabled', false);
    }

    public function initiate(Order $order): array
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => Payment::METHOD_ONLINE,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'status' => Payment::STATUS_PENDING,
            'metadata' => [
                'provider' => config('services.online_payment.provider'),
                'integration_status' => 'ready_for_provider',
                'note' => 'Passerelle Visa / IBAN européen à connecter.',
            ],
        ]);

        $order->update([
            'payment_method' => Payment::METHOD_ONLINE,
            'status' => Order::STATUS_PENDING,
        ]);

        // Placeholder : brancher ici le SDK/API du prestataire (Visa, PSP IBAN, Mobile Money).
        // Ne jamais exposer ONLINE_PAYMENT_SECRET_KEY au frontend.
        if (! $this->isAvailable()) {
            throw new RuntimeException(
                'Le paiement en ligne sera bientôt disponible. Utilisez Wise pour le moment.'
            );
        }

        return [
            'payment' => $payment,
            'redirect_url' => null,
            'checkout_session' => null,
            'public_key' => config('services.online_payment.public_key'),
            'amount' => (float) $order->amount,
            'currency' => $order->currency,
            'description' => config('services.plan.description'),
        ];
    }
}
