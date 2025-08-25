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
        Schema::create('cat_temas_de_interes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tema', 255);
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
        Schema::dropIfExists('cat_temas_de_interes');
    }
};
