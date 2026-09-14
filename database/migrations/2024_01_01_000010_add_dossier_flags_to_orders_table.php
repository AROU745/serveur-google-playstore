<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('company_eligible_confirmed')->default(false)->after('company_years');
            $table->timestamp('dossier_submitted_at')->nullable()->after('company_eligible_confirmed');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['company_eligible_confirmed', 'dossier_submitted_at']);
        });
    }
};
