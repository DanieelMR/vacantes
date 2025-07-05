<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa', 150);
            $table->string('contacto_rh', 100);
            $table->string('correo', 100);
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->string('sector_empresarial', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
