<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cat_temas_de_interes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('cat_problematicas', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cat_tema_de_interes_id')->references('id')->on('cat_temas_de_interes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cat_temas_de_interes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('cat_problematicas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['cat_tema_de_interes_id']);
        });
    }
};
