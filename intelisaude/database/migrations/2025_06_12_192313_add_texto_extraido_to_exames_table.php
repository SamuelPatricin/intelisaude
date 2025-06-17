<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('exames', function (Blueprint $table) {
            $table->text('texto_extraido')->nullable()->after('caminho_arquivo');
        });
    }

    public function down(): void
    {
        Schema::table('exames', function (Blueprint $table) {
            $table->dropColumn('texto_extraido');
        });
    }
};
