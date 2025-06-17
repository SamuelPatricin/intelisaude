<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('exames', function (Blueprint $table) {
            $table->text('analise_ia')->nullable()->after('nome_arquivo');
        });
    }

    public function down()
    {
        Schema::table('exames', function (Blueprint $table) {
            $table->dropColumn('analise_ia');
        });
    }

};
