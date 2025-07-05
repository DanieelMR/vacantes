<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 10)->unique(); // ISC, IGE, IE, etc.
            $table->string('nombre_carrera', 100);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Insertar carreras por defecto
        DB::table('carreras')->insert([
            ['clave' => 'ISC', 'nombre_carrera' => 'Ingeniería en Sistemas Computacionales'],
            ['clave' => 'IGE', 'nombre_carrera' => 'Ingeniería en Gestión Empresarial'],
            ['clave' => 'IE', 'nombre_carrera' => 'Ingeniería Electrónica'],
            ['clave' => 'IM', 'nombre_carrera' => 'Ingeniería Mecánica'],
            ['clave' => 'IIA', 'nombre_carrera' => 'Ingeniería en Industrias Alimentarias'],
            ['clave' => 'CP', 'nombre_carrera' => 'Contador Público'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('carreras');
    }
};
