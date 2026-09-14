<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $type = 'created'
    ) {
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'created' => 'Confirmation de commande — '.$this->order->order_number,
            'proof_received' => 'Preuve de paiement reçue — '.$this->order->order_number,
            'paid' => 'Paiement confirmé — '.$this->order->order_number,
        ];

        return new Envelope(
            subject: $subjects[$this->type] ?? $subjects['created'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
        );
    }
}
