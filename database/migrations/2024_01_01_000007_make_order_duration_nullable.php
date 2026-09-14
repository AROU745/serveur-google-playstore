<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rendre duration_months nullable sans doctrine/dbal
        DB::statement('ALTER TABLE orders MODIFY duration_months SMALLINT UNSIGNED NULL DEFAULT NULL');
        DB::table('orders')->update(['duration_months' => null]);
    }

    public function down(): void
    {
        DB::table('orders')->whereNull('duration_months')->update(['duration_months' => 12]);
        DB::statement('ALTER TABLE orders MODIFY duration_months SMALLINT UNSIGNED NOT NULL DEFAULT 12');
    }
};
