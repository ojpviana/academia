<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciciosSeeder extends Seeder
{
    public function run()
    {
        $exercicios = [
            // Peito
            ['nome' => 'Supino Reto com Barra', 'grupo_muscular' => 'Peito'],
            ['nome' => 'Supino Inclinado com Halteres', 'grupo_muscular' => 'Peito'],
            ['nome' => 'Crucifixo no Crossover', 'grupo_muscular' => 'Peito'],

            // Costas
            ['nome' => 'Puxada Frontal', 'grupo_muscular' => 'Costas'],
            ['nome' => 'Remada Curvada', 'grupo_muscular' => 'Costas'],
            ['nome' => 'Pulldown', 'grupo_muscular' => 'Costas'],

            // Pernas
            ['nome' => 'Agachamento Livre', 'grupo_muscular' => 'Pernas'],
            ['nome' => 'Leg Press 45º', 'grupo_muscular' => 'Pernas'],
            ['nome' => 'Cadeira Extensora', 'grupo_muscular' => 'Pernas'],
            ['nome' => 'Mesa Flexora', 'grupo_muscular' => 'Pernas'],

            // Ombros
            ['nome' => 'Desenvolvimento com Halteres', 'grupo_muscular' => 'Ombros'],
            ['nome' => 'Elevação Lateral', 'grupo_muscular' => 'Ombros'],

            // Braços
            ['nome' => 'Rosca Direta (Barra W)', 'grupo_muscular' => 'Bíceps'],
            ['nome' => 'Tríceps Pulley', 'grupo_muscular' => 'Tríceps'],
            ['nome' => 'Tríceps Testa', 'grupo_muscular' => 'Tríceps'],

            // Core
            ['nome' => 'Abdominal Supra', 'grupo_muscular' => 'Abdômen'],
            ['nome' => 'Prancha Isométrica', 'grupo_muscular' => 'Abdômen'],
        ];

        foreach ($exercicios as $ex) {
            DB::table('exercicios_catalogo')->insert($ex);
        }
    }
}
