<div style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.5;">
    <h2>Google Play Server Service</h2>
    @if($type === 'paid')
        <p>Votre paiement pour la commande <strong>{{ $order->order_number }}</strong> a été confirmé.</p>
    @elseif($type === 'proof_received')
        <p>Nous avons bien reçu votre preuve de paiement pour la commande <strong>{{ $order->order_number }}</strong>. Validation en cours.</p>
    @else
        <p>Merci pour votre commande <strong>{{ $order->order_number }}</strong>.</p>
    @endif
    <p>Montant : <strong>{{ $order->formattedAmount() }}</strong> — Durée : {{ $order->formattedDuration() }}</p>
    <p>Projet : {{ $order->project_name }} ({{ $order->package_name }})</p>
    <p style="font-size: 12px; color: #64748b;">Service indépendant — Non affilié à Google LLC</p>
</div>
