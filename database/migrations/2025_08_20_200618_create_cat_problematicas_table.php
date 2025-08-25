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
        Schema::create('cat_problematicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion_problematica', 255);
            $table->unsignedInteger('cat_tema_de_interes_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->timestamps();
            $table->tinyInteger('activo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_problematicas');
    }
};
