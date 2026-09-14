<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nif')->nullable()->after('notes');
            $table->string('nif_document_path')->nullable()->after('nif');
            $table->string('rccm')->nullable()->after('nif_document_path');
            $table->string('rccm_document_path')->nullable()->after('rccm');
            $table->string('id_document_type')->nullable()->after('rccm_document_path');
            $table->string('id_document_path')->nullable()->after('id_document_type');
            $table->unsignedTinyInteger('company_years')->nullable()->after('id_document_path');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nif',
                'nif_document_path',
                'rccm',
                'rccm_document_path',
                'id_document_type',
                'id_document_path',
                'company_years',
            ]);
        });
    }
};
