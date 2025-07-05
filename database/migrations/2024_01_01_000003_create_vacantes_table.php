<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vacantes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->text('descripcion');
            $table->enum('tipo', ['servicio_social', 'residencia_profesional']);
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->json('carreras_dirigidas'); // Array de IDs de carreras
            $table->enum('estado', ['pendiente', 'publicada', 'cerrada'])->default('pendiente');
            $table->text('requisitos')->nullable();
            $table->string('modalidad', 50)->default('presencial'); // presencial, remoto, hibrido
            $table->decimal('duracion_meses', 3, 1)->nullable(); // 6.0, 4.5, etc.
            $table->boolean('con_beca')->default(false);
            $table->decimal('monto_beca', 8, 2)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_limite_postulacion')->nullable();
            $table->integer('num_plazas')->default(1);
            $table->text('observaciones_admin')->nullable();
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->foreignId('aprobado_por')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacantes');
    }
};
