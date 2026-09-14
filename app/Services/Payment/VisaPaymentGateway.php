<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;

/**
 * Dossier Visa / vérification entreprise.
 * Aucune donnée de carte (PAN/CVC) n'est collectée ici.
 * Le règlement carte réel doit passer par un prestataire certifié PCI.
 */
class VisaPaymentGateway implements PaymentGatewayInterface
{
    public function getIdentifier(): string
    {
        return Payment::METHOD_VISA;
    }

    public function isAvailable(): bool
    {
        return true;
    }

    public function initiate(Order $order): array
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => Payment::METHOD_VISA,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'status' => Payment::STATUS_AWAITING,
            'metadata' => [
                'provider' => 'visa_dossier',
                'integration_status' => 'kyc_received_awaiting_secure_checkout',
                'note' => 'Dossier entreprise reçu. Paiement carte via prestataire certifié à brancher (aucune carte stockée sur ce site).',
            ],
        ]);

        $order->update([
            'payment_method' => Payment::METHOD_VISA,
            'status' => Order::STATUS_AWAITING,
        ]);

        return [
            'payment' => $payment,
            'redirect_url' => null,
            'amount' => (float) $order->amount,
            'currency' => $order->currency,
            'description' => config('services.plan.description'),
        ];
    }
}
