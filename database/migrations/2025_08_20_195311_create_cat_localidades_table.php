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
        Schema::create('cat_localidades', function (Blueprint $table) {
            $table->id('id_localidad');
            $table->string('entidad', 255);
            $table->string('nombre_entidad', 255);
            $table->string('municipio', 255);
            $table->string('nombre_municipio', 255);
            $table->string('localidad', 255)->nullable()->default(null);
            $table->string('nombre_localidad', 255);
            $table->string('longitud', 255)->nullable()->default(null);
            $table->string('latitud', 255)->nullable()->default(null);
            $table->string('altitud', 255)->nullable()->default(null);
            $table->tinyInteger('activo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_localidades');
    }
};
