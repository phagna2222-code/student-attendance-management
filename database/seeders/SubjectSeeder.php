<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'MATH', 'name_en' => 'Mathematics',       'name_kh' => 'គណិតវិទ្យា',     'description' => 'Algebra, geometry, calculus.'],
            ['code' => 'KH',   'name_en' => 'Khmer Language',    'name_kh' => 'ភាសាខ្មែរ',     'description' => 'Reading, writing, literature.'],
            ['code' => 'EN',   'name_en' => 'English Language',  'name_kh' => 'ភាសាអង់គ្លេស',  'description' => 'Reading, writing, conversation.'],
            ['code' => 'PHY',  'name_en' => 'Physics',           'name_kh' => 'រូបវិទ្យា',     'description' => 'Mechanics, electricity, optics.'],
            ['code' => 'CHE',  'name_en' => 'Chemistry',         'name_kh' => 'គីមីវិទ្យា',    'description' => 'Periodic table, reactions.'],
            ['code' => 'BIO',  'name_en' => 'Biology',           'name_kh' => 'ជីវវិទ្យា',    'description' => 'Cells, genetics, ecology.'],
            ['code' => 'HIS',  'name_en' => 'History',           'name_kh' => 'ប្រវត្តិវិទ្យា', 'description' => 'World history, Cambodian history.'],
            ['code' => 'GEO',  'name_en' => 'Geography',         'name_kh' => 'ភូមិវិទ្យា',    'description' => 'Physical and human geography.'],
            ['code' => 'ICT',  'name_en' => 'ICT',               'name_kh' => 'កុំព្យូទ័រ',    'description' => 'Computer literacy and programming.'],
            ['code' => 'PE',   'name_en' => 'Physical Education','name_kh' => 'អប់រំកាយ',     'description' => 'Sports and physical activity.'],
        ];
        foreach ($rows as $r) {
            Subject::updateOrCreate(['code' => $r['code']], $r + ['status' => 'active']);
        }
    }
}
