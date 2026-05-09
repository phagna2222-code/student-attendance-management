<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use Illuminate\Database\Seeder;

class GradeLevelSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'G1',  'name_en' => 'Grade 1',  'name_kh' => 'ថ្នាក់ទី១',  'level_order' => 1],
            ['code' => 'G2',  'name_en' => 'Grade 2',  'name_kh' => 'ថ្នាក់ទី២',  'level_order' => 2],
            ['code' => 'G3',  'name_en' => 'Grade 3',  'name_kh' => 'ថ្នាក់ទី៣',  'level_order' => 3],
            ['code' => 'G4',  'name_en' => 'Grade 4',  'name_kh' => 'ថ្នាក់ទី៤',  'level_order' => 4],
            ['code' => 'G5',  'name_en' => 'Grade 5',  'name_kh' => 'ថ្នាក់ទី៥',  'level_order' => 5],
            ['code' => 'G6',  'name_en' => 'Grade 6',  'name_kh' => 'ថ្នាក់ទី៦',  'level_order' => 6],
            ['code' => 'G7',  'name_en' => 'Grade 7',  'name_kh' => 'ថ្នាក់ទី៧',  'level_order' => 7],
            ['code' => 'G8',  'name_en' => 'Grade 8',  'name_kh' => 'ថ្នាក់ទី៨',  'level_order' => 8],
            ['code' => 'G9',  'name_en' => 'Grade 9',  'name_kh' => 'ថ្នាក់ទី៩',  'level_order' => 9],
            ['code' => 'G10', 'name_en' => 'Grade 10', 'name_kh' => 'ថ្នាក់ទី១០', 'level_order' => 10],
            ['code' => 'G11', 'name_en' => 'Grade 11', 'name_kh' => 'ថ្នាក់ទី១១', 'level_order' => 11],
            ['code' => 'G12', 'name_en' => 'Grade 12', 'name_kh' => 'ថ្នាក់ទី១២', 'level_order' => 12],
        ];
        foreach ($rows as $r) {
            GradeLevel::updateOrCreate(['code' => $r['code']], $r + ['status' => 'active']);
        }
    }
}
