<div style="font-family: Arial, sans-serif; color: #1e293b;">
    <h2>Nouvelle preuve Wise</h2>
    <p>Commande : <strong>{{ $order->order_number }}</strong></p>
    <p>Client : {{ $order->customer->full_name }} ({{ $order->customer->email }})</p>
    <p>Référence : {{ $payment->transaction_reference }}</p>
    <p>Payeur : {{ $payment->payer_name }} — {{ $payment->payer_email }}</p>
    <p>Date déclarée : {{ optional($payment->payment_date)->format('d/m/Y') }}</p>
    <p>Montant : {{ $order->formattedAmount() }}</p>
</div>
