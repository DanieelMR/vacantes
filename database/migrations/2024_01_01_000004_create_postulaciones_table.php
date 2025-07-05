<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacante_id')->constrained('vacantes')->onDelete('cascade');
            $table->string('nombre_estudiante', 100);
            $table->string('matricula', 20);
            $table->string('correo_est', 100);
            $table->string('telefono_est', 20)->nullable();
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->integer('semestre_actual');
            $table->decimal('promedio', 4, 2)->nullable();
            $table->text('mensaje_adicional')->nullable();
            $table->enum('estado_postulacion', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
            $table->timestamp('fecha_postulacion');
            $table->timestamps();
            
            // Evitar postulaciones duplicadas del mismo estudiante a la misma vacante
            $table->unique(['vacante_id', 'matricula']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('postulaciones');
    }
};
