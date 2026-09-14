<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.index', [
            'settings' => [
                'company_name' => Setting::getValue('company_name', 'Google Play Server Service'),
                'support_email' => Setting::getValue('support_email', config('mail.from.address')),
                'support_phone' => Setting::getValue('support_phone', ''),
                'wise_instructions' => Setting::getValue(
                    'wise_instructions',
                    "1. Cliquez sur « Payer maintenant sur Wise » pour ouvrir https://wise.com/pay/me/kodjodenisa\n2. Sur Wise, saisissez le montant 1 082 USD et effectuez le paiement.\n3. Notez le numéro de transaction Wise.\n4. Revenez sur la page de commande et déclarez votre paiement avec la preuve."
                ),
            ],
            'wiseUrlConfigured' => filled(config('services.wise.payment_url')),
            'onlineEnabled' => (bool) config('services.online_payment.enabled'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:150'],
            'support_email' => ['required', 'email', 'max:150'],
            'support_phone' => ['nullable', 'string', 'max:50'],
            'wise_instructions' => ['required', 'string', 'max:5000'],
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value);
        }

        return back()->with('success', 'Paramètres enregistrés.');
    }
}
