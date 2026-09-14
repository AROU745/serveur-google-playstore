<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\Payment;
use App\Services\OrderService;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected PaymentGatewayManager $paymentManager
    ) {
    }

    public function show(): View
    {
        return view('payment.index', [
            'plan' => config('services.plan'),
            'methods' => $this->paymentManager->availableMethods(),
            'wiseUrl' => config('services.wise.payment_url'),
            'whopUrl' => config('services.whop.checkout_url'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'company_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:100'],
            'project_name' => ['required', 'string', 'max:200'],
            'package_name' => ['required', 'string', 'max:200'],
            'billing_address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', Rule::in([Payment::METHOD_WISE, Payment::METHOD_VISA])],
            'nif' => ['required_if:payment_method,visa', 'nullable', 'string', 'max:100'],
            'nif_document' => ['required_if:payment_method,visa', 'nullable', 'file', 'mimes:pdf', 'max:5120'],
            'rccm' => ['required_if:payment_method,visa', 'nullable', 'string', 'max:100'],
            'rccm_document' => ['required_if:payment_method,visa', 'nullable', 'file', 'mimes:pdf', 'max:5120'],
            'cfe' => ['required_if:payment_method,visa', 'nullable', 'string', 'max:100'],
            'cfe_document' => ['required_if:payment_method,visa', 'nullable', 'file', 'mimes:pdf', 'max:5120'],
            'id_document_type' => ['required_if:payment_method,visa', 'nullable', Rule::in(['cni', 'passeport'])],
            'id_document' => ['required_if:payment_method,visa', 'nullable', 'file', 'mimes:pdf', 'max:5120'],
            'company_years' => ['required_if:payment_method,visa', 'nullable', 'integer', 'min:3', 'max:120'],
            'company_eligible_confirm' => ['required_if:payment_method,visa', 'accepted'],
        ], [
            'company_years.min' => 'L\'entreprise doit justifier d\'au moins 3 années d\'existence.',
            'company_eligible_confirm.accepted' => 'Veuillez confirmer que l\'entreprise a plus de trois ans d\'existence.',
            'nif_document.required_if' => 'Le NIF en PDF est obligatoire pour le paiement Visa.',
            'rccm_document.required_if' => 'Le RCCM en PDF est obligatoire pour le paiement Visa.',
            'cfe_document.required_if' => 'Le CFE en PDF est obligatoire pour le paiement Visa.',
            'id_document.required_if' => 'La pièce d\'identité ou le passeport en PDF est obligatoire pour le paiement Visa.',
        ]);

        if ($data['payment_method'] === Payment::METHOD_VISA) {
            $data['nif_document_path'] = $request->file('nif_document')?->store('kyc/nif', 'public');
            $data['rccm_document_path'] = $request->file('rccm_document')?->store('kyc/rccm', 'public');
            $data['cfe_document_path'] = $request->file('cfe_document')?->store('kyc/cfe', 'public');
            $data['id_document_path'] = $request->file('id_document')?->store('kyc/id', 'public');
        }

        $order = $this->orderService->createOrder($data);

        session([
            'current_order_number' => $order->order_number,
        ]);

        try {
            Mail::to($order->customer->email)->send(new OrderConfirmationMail($order, 'created'));
        } catch (\Throwable $e) {
            report($e);
        }

        try {
            $result = $this->orderService->initiatePayment($order, $data['payment_method']);
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('payment.pending')
                ->with('warning', $e->getMessage());
        } catch (\InvalidArgumentException $e) {
            $order->update(['status' => Order::STATUS_FAILED]);

            return redirect()
                ->route('payment.failed')
                ->with('error', $e->getMessage());
        }

        if ($data['payment_method'] === Payment::METHOD_WISE) {
            return redirect()
                ->route('payment.pending')
                ->with('wise_redirect', $result['redirect_url'] ?? config('services.wise.payment_url'))
                ->with('success', 'Vos informations ont été enregistrées. Complétez le paiement Wise puis confirmez ci-dessous.');
        }

        return redirect()
            ->route('payment.pending')
            ->with('success', 'Vos informations et documents ont été enregistrés en base de données (commande '.$order->order_number.'). Après vérification, réponse sous 15 jours maximum avec un lien de paiement UE.');
    }

    public function success(Request $request): View|RedirectResponse
    {
        $order = $this->resolveOrder($request);

        if (! $order) {
            return redirect()->route('payment')->with('error', 'Commande introuvable.');
        }

        return view('payment.success', compact('order'));
    }

    public function pending(Request $request): View|RedirectResponse
    {
        $order = $this->resolveOrder($request);

        if (! $order) {
            return redirect()->route('payment')->with('error', 'Commande introuvable.');
        }

        return view('payment.pending', [
            'order' => $order,
            'plan' => config('services.plan'),
            'wiseUrl' => config('services.wise.payment_url'),
            'wiseInstructions' => \App\Models\Setting::getValue(
                'wise_instructions',
                "1. Cliquez sur « Payer maintenant sur Wise » pour ouvrir https://wise.com/pay/me/kodjodenisa\n2. Sur Wise, saisissez le montant 1 082 USD et effectuez le paiement.\n3. Notez le numéro de transaction Wise.\n4. Revenez ici, remplissez le formulaire et joignez une preuve (capture ou PDF)."
            ),
        ]);
    }

    public function failed(Request $request): View|RedirectResponse
    {
        $order = $this->resolveOrder($request);

        return view('payment.failed', compact('order'));
    }

    public function submitProof(Request $request): RedirectResponse
    {
        $request->validate([
            'order_number' => ['required', 'string'],
            'transaction_reference' => ['required', 'string', 'max:150'],
            'payer_name' => ['required', 'string', 'max:150'],
            'payer_email' => ['required', 'email', 'max:150'],
            'payment_date' => ['required', 'date', 'before_or_equal:today'],
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $order = Order::where('order_number', $request->order_number)->firstOrFail();

        $this->orderService->submitWiseProof($order, $request->only([
            'transaction_reference',
            'payer_name',
            'payer_email',
            'payment_date',
        ]), $request->file('proof'));

        session(['current_order_number' => $order->order_number]);

        return redirect()
            ->route('order.show', $order->order_number)
            ->with('success', 'Preuve de paiement envoyée. Nous confirmerons votre abonnement sous peu.');
    }

    protected function resolveOrder(Request $request): ?Order
    {
        $number = $request->query('order')
            ?? $request->query('order_number')
            ?? session('current_order_number');

        if (! $number) {
            return null;
        }

        return Order::with('customer', 'latestPayment', 'invoice')
            ->where('order_number', $number)
            ->first();
    }
}
