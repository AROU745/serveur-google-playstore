<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function getIdentifier(): string;

    public function initiate(Order $order): array;

    public function isAvailable(): bool;
}
