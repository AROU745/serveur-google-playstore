<?php

namespace App\Services;

use App\Mail\OrderConfirmationMail;
use App\Mail\PaymentProofReceivedMail;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function __construct(
        protected PaymentGatewayManager $paymentManager
    ) {
    }

    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $customer = Customer::create([
                'full_name' => $data['full_name'],
                'company_name' => $data['company_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'country' => $data['country'],
                'billing_address' => $data['billing_address'],
            ]);

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_id' => $customer->id,
                'project_name' => $data['project_name'],
                'package_name' => $data['package_name'],
                'amount' => config('services.plan.amount'),
                'currency' => config('services.plan.currency'),
                'duration_months' => config('services.plan.duration_months'),
                'payment_method' => $data['payment_method'],
                'status' => Order::STATUS_PENDING,
                'nif' => $data['nif'] ?? null,
                'nif_document_path' => $data['nif_document_path'] ?? null,
                'rccm' => $data['rccm'] ?? null,
                'rccm_document_path' => $data['rccm_document_path'] ?? null,
                'cfe' => $data['cfe'] ?? null,
                'cfe_document_path' => $data['cfe_document_path'] ?? null,
                'id_document_type' => $data['id_document_type'] ?? null,
                'id_document_path' => $data['id_document_path'] ?? null,
                'company_years' => $data['company_years'] ?? null,
                'company_eligible_confirmed' => ! empty($data['company_eligible_confirm']),
                'dossier_submitted_at' => now(),
            ]);

            Invoice::create([
                'order_id' => $order->id,
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'amount' => $order->amount,
                'currency' => $order->currency,
                'status' => Invoice::STATUS_DRAFT,
            ]);

            return $order->load('customer', 'invoice');
        });
    }

    public function initiatePayment(Order $order, string $method): array
    {
        $gateway = $this->paymentManager->gateway($method);

        return $gateway->initiate($order);
    }

    public function submitWiseProof(Order $order, array $data, ?UploadedFile $proof = null): Payment
    {
        $path = null;

        if ($proof) {
            $path = $proof->store('proofs', 'public');
        }

        $payment = $order->latestPayment;

        if (! $payment) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => Payment::METHOD_WISE,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'status' => Payment::STATUS_AWAITING,
            ]);
        }

        $payment->update([
            'transaction_reference' => $data['transaction_reference'],
            'payer_name' => $data['payer_name'],
            'payer_email' => $data['payer_email'],
            'payment_date' => $data['payment_date'],
            'proof_path' => $path ?? $payment->proof_path,
            'status' => Payment::STATUS_AWAITING,
            'metadata' => array_merge($payment->metadata ?? [], [
                'customer_declared_paid' => true,
                'declared_at' => now()->toIso8601String(),
            ]),
        ]);

        $order->update(['status' => Order::STATUS_AWAITING]);

        try {
            Mail::to(config('mail.from.address'))->send(new PaymentProofReceivedMail($order, $payment));
            Mail::to($order->customer->email)->send(new OrderConfirmationMail($order, 'proof_received'));
        } catch (\Throwable $e) {
            report($e);
        }

        return $payment->fresh();
    }

    public function markAsPaid(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => Order::STATUS_PAID]);

            $order->latestPayment?->update([
                'status' => Payment::STATUS_CONFIRMED,
                'confirmed_at' => now(),
            ]);

            $order->invoice?->update([
                'status' => Invoice::STATUS_PAID,
                'issued_at' => now(),
            ]);
        });

        try {
            Mail::to($order->customer->email)->send(new OrderConfirmationMail($order, 'paid'));
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
