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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('cat_sexo_id')->references('id')->on('cat_sexo');
            $table->foreign('cat_tipo_usuario_id')->references('id')->on('cat_tipos_de_usuarios');
            $table->foreign('cat_localidad_id')->references('id_localidad')->on('cat_localidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
