<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@gpss.local'],
            [
                'name' => 'Administrateur',
                'password' => 'Admin@GPSS2024',
                'role' => 'admin',
            ]
        );

        $defaults = [
            'company_name' => 'Google Play Server Service',
            'support_email' => 'support@gpss.local',
            'support_phone' => '',
            'wise_instructions' => "1. Cliquez sur « Payer maintenant sur Wise » pour ouvrir https://wise.com/pay/me/kodjodenisa\n2. Sur Wise, saisissez le montant 1 082 USD et effectuez le paiement.\n3. Notez le numéro de transaction Wise.\n4. Revenez ici, remplissez le formulaire et joignez une preuve (capture ou PDF).",
        ];

        foreach ($defaults as $key => $value) {
            Setting::setValue($key, $value);
        }
    }
}
