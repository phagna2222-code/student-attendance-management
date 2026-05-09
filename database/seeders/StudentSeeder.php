<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Shift;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $year      = AcademicYear::where('code', '2025-2026')->first();
        $morning   = Shift::where('code', 'MORN')->first();
        $afternoon = Shift::where('code', 'AFTER')->first();

        $khFirst = ['សុខ', 'ចាន់', 'ឡុង', 'ពេជ្រ', 'ម៉ៅ', 'សៅ', 'ឆាយ', 'ឃុន', 'ហុង', 'ឈុន'];
        $khLast  = ['ដារ៉ា', 'ស៊ីណា', 'បុប្ផា', 'រ័ត្នា', 'សុភ័ក្ត្រ', 'វាសនា', 'រស្មី', 'ជ័យ', 'ប៊ុនធឿន', 'ផានិត'];
        $enFirst = ['Sok',   'Chan',  'Long', 'Pich',  'Mao',  'Sao',  'Chhay', 'Khun', 'Hong', 'Chhun'];
        $enLast  = ['Dara',  'Sina',  'Bopha','Ratana','Sopheak','Veasna','Reaksmey','Chey','Bunthoeun','Phanit'];

        $counter = 0;
        foreach (SchoolClass::all() as $class) {
            // 8 students per class (a small but realistic demo size)
            for ($n = 1; $n <= 8; $n++) {
                $counter++;
                $code = sprintf('STD-2025-%04d', $counter);
                $first = $n - 1;
                $name_en = $enFirst[$first % count($enFirst)].' '.$enLast[$counter % count($enLast)];
                $name_kh = $khFirst[$first % count($khFirst)].' '.$khLast[$counter % count($khLast)];
                $gender  = $counter % 2 === 0 ? 'male' : 'female';
                $shift   = $class->shift_id;

                Student::updateOrCreate(
                    ['student_code' => $code],
                    [
                        'branch_id'        => $class->branch_id,
                        'current_class_id' => $class->id,
                        'academic_year_id' => $year?->id,
                        'shift_id'         => $shift,
                        'student_no'       => sprintf('%04d', $counter),
                        'name_kh'          => $name_kh,
                        'name_en'          => $name_en,
                        'gender'           => $gender,
                        'date_of_birth'    => now()->subYears(13)->subDays($counter % 365)->toDateString(),
                        'phone'            => null,
                        'address'          => 'Phnom Penh, Cambodia',
                        'qr_code_value'    => 'QR-'.$code,
                        'status'           => 'studying',
                        'admission_date'   => '2025-09-01',
                    ]
                );
            }
        }
    }
}
