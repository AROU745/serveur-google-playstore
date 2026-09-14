<?php

namespace App\Services\Payment;

use App\Models\Payment;
use InvalidArgumentException;

class PaymentGatewayManager
{
    /** @var array<string, PaymentGatewayInterface> */
    protected array $gateways = [];

    public function __construct(
        WisePaymentGateway $wise,
        VisaPaymentGateway $visa,
        OnlinePaymentGateway $online
    ) {
        $this->gateways[$wise->getIdentifier()] = $wise;
        $this->gateways[$visa->getIdentifier()] = $visa;
        $this->gateways[$online->getIdentifier()] = $online;
    }

    public function gateway(string $method): PaymentGatewayInterface
    {
        if (! isset($this->gateways[$method])) {
            throw new InvalidArgumentException("Méthode de paiement inconnue : {$method}");
        }

        return $this->gateways[$method];
    }

    /**
     * @return array<string, PaymentGatewayInterface>
     */
    public function all(): array
    {
        return $this->gateways;
    }

    public function availableMethods(): array
    {
        return [
            Payment::METHOD_WISE => [
                'id' => Payment::METHOD_WISE,
                'label' => 'Payer avec Wise',
                'description' => 'Virement international sécurisé via Wise',
                'available' => true,
                'icon' => 'fa-building-columns',
            ],
            Payment::METHOD_VISA => [
                'id' => Payment::METHOD_VISA,
                'label' => 'Payer par Visa',
                'description' => 'Dossier entreprise + paiement carte via circuit sécurisé',
                'available' => true,
                'icon' => 'fa-cc-visa',
            ],
        ];
    }
}
