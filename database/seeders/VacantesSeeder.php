<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\Vacante;
use App\Models\Carrera;
use Carbon\Carbon;

class VacantesSeeder extends Seeder
{
    public function run()
    {
        $empresas = [
            [
                'nombre_empresa' => 'Tecnologías Innovadoras SA',
                'contacto_rh' => 'Juan Pérez',
                'correo' => 'contacto@tecnologiasinnovadoras.com',
                'telefono' => '777-123-4567',
                'sector_empresarial' => 'Tecnología'
            ],
            [
                'nombre_empresa' => 'Industrias Manufactureras del Valle',
                'contacto_rh' => 'María González',
                'correo' => 'rh@industriasvalle.com', 
                'telefono' => '777-234-5678',
                'sector_empresarial' => 'Manufactura'
            ],
            [
                'nombre_empresa' => 'Consultores Empresariales',
                'contacto_rh' => 'Carlos Ramírez',
                'correo' => 'info@consultoresempresariales.com',
                'telefono' => '777-345-6789',
                'sector_empresarial' => 'Consultoría'
            ],
            [
                'nombre_empresa' => 'Electrónica Avanzada',
                'contacto_rh' => 'Ana Martínez',
                'correo' => 'recruiting@electronicaavanzada.com',
                'telefono' => '777-456-7890',
                'sector_empresarial' => 'Electrónica'
            ]
        ];

        foreach ($empresas as $empresaData) {
            Empresa::firstOrCreate(['nombre_empresa' => $empresaData['nombre_empresa']], $empresaData);
        }

        // Crear vacantes idénticas al PORTAL_FUNCIONAL.html
        $vacantesData = [
            [
                'empresa' => 'Tecnologías Innovadoras SA',
                'titulo' => 'Desarrollador Web Junior',
                'tipo' => 'servicio_social',
                'carreras' => ['ISC', 'IGE'],
                'estado' => 'publicada',
                'descripcion' => 'Buscamos estudiante para desarrollo de aplicaciones web usando tecnologías modernas como React, Node.js, y bases de datos modernas. Excelente oportunidad para aplicar conocimientos adquiridos en el aula.',
                'fecha_inicio' => Carbon::now()->addDays(7),
                'fecha_fin' => Carbon::now()->addDays(187), // 6 meses
                'salario' => 8000,
                'horas_semanales' => 30,
                'beca' => true,
                'created_at' => Carbon::now()->subDays(2)
            ],
            [
                'empresa' => 'Industrias Manufactureras del Valle',
                'titulo' => 'Ingeniero de Procesos',
                'tipo' => 'residencia_profesional',
                'carreras' => ['IM', 'IIA'],
                'estado' => 'publicada',
                'descripcion' => 'Oportunidad para residencia en optimización de procesos productivos. Trabajarás con tecnología de punta en mejora continua y análisis de eficiencia operacional.',
                'fecha_inicio' => Carbon::now()->addDays(14),
                'fecha_fin' => Carbon::now()->addDays(104), // 3 meses
                'salario' => 12000,
                'horas_semanales' => 40,
                'beca' => false,
                'created_at' => Carbon::now()->subWeek()
            ],
            [
                'empresa' => 'Consultores Empresariales',
                'titulo' => 'Asistente Contable',
                'tipo' => 'servicio_social',
                'carreras' => ['CP'],
                'estado' => 'publicada',
                'descripcion' => 'Apoyo en procesos contables y administrativos de la empresa. Manejo de sistemas contables, elaboración de reportes financieros y apoyo en auditorías.',
                'fecha_inicio' => Carbon::now()->addDays(10),
                'fecha_fin' => Carbon::now()->addDays(190), // 6 meses
                'salario' => 7000,
                'horas_semanales' => 25,
                'beca' => false,
                'created_at' => Carbon::now()->subDays(3)
            ],
            [
                'empresa' => 'Electrónica Avanzada',
                'titulo' => 'Técnico en Sistemas Embebidos',
                'tipo' => 'residencia_profesional',
                'carreras' => ['IE', 'ISC'],
                'estado' => 'pendiente',
                'descripcion' => 'Desarrollo de sistemas embebidos para IoT usando Arduino, Raspberry Pi y microcontroladores. Proyecto enfocado en domótica y automatización industrial.',
                'fecha_inicio' => Carbon::now()->addDays(21),
                'fecha_fin' => Carbon::now()->addDays(111), // 3 meses
                'salario' => 10000,
                'horas_semanales' => 35,
                'beca' => true,
                'created_at' => Carbon::now()
            ]
        ];

        foreach ($vacantesData as $vacanteData) {
            $empresa = Empresa::where('nombre_empresa', $vacanteData['empresa'])->first();
            
            $vacante = Vacante::create([
                'empresa_id' => $empresa->id,
                'titulo' => $vacanteData['titulo'],
                'descripcion' => $vacanteData['descripcion'],
                'tipo' => $vacanteData['tipo'],
                'estado' => $vacanteData['estado'],
                'fecha_inicio' => $vacanteData['fecha_inicio'],
                'fecha_limite_postulacion' => $vacanteData['fecha_fin'],
                'con_beca' => $vacanteData['beca'],
                'monto_beca' => $vacanteData['beca'] ? $vacanteData['salario'] : null,
                'duracion_meses' => $vacanteData['tipo'] === 'servicio_social' ? 6.0 : 3.0,
                'carreras_dirigidas' => json_encode($vacanteData['carreras']),
                'created_at' => $vacanteData['created_at'],
                'updated_at' => $vacanteData['created_at']
            ]);

            // Las carreras ya están guardadas en el campo JSON 'carreras_dirigidas'
        }

        // Crear algunas postulaciones de ejemplo
        $vacantesPublicadas = Vacante::where('estado', 'publicada')->get();
        
        foreach ($vacantesPublicadas as $vacante) {
            $numeroPostulaciones = match($vacante->titulo) {
                'Desarrollador Web Junior' => 8,
                'Ingeniero de Procesos' => 12,
                'Asistente Contable' => 5,
                default => 0
            };

            // Crear postulaciones ficticias
            for ($i = 1; $i <= $numeroPostulaciones; $i++) {
                $carrerasDisponibles = json_decode($vacante->carreras_dirigidas);
                $carreraSeleccionada = $carrerasDisponibles[array_rand($carrerasDisponibles)];
                $carreraObj = Carrera::where('clave', $carreraSeleccionada)->first();
                
                \DB::table('postulaciones')->insert([
                    'vacante_id' => $vacante->id,
                    'nombre_estudiante' => "Estudiante $i",
                    'matricula' => "2021" . str_pad($i + ($vacante->id * 100), 4, '0', STR_PAD_LEFT),
                    'correo_est' => "estudiante$i@cuautla.tecnm.mx",
                    'telefono_est' => "777-" . rand(100, 999) . "-" . rand(1000, 9999),
                    'carrera_id' => $carreraObj->id,
                    'semestre_actual' => rand(6, 10),
                    'promedio' => rand(80, 95) + (rand(0, 99) / 100),
                    'fecha_postulacion' => Carbon::now()->subDays(rand(1, 30)),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 30))
                ]);
            }
        }

        $this->command->info('✅ Vacantes de muestra creadas exitosamente');
        $this->command->info('📊 Total: 4 vacantes, 3 publicadas, 1 pendiente');
        $this->command->info('👥 Total: 25 postulaciones distribuidas');
    }
}
