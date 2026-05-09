<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['email' => 'teacher@example.com',  'code' => 'TCH-2025-0001', 'name_en' => 'Demo Teacher',   'name_kh' => 'លោកគ្រូ ដឺម៉ូ',   'gender' => 'male',   'date_of_birth' => '1985-04-12'],
            ['email' => 'teacher2@example.com', 'code' => 'TCH-2025-0002', 'name_en' => 'Chan Dara',      'name_kh' => 'ចាន់ ដារ៉ា',     'gender' => 'female', 'date_of_birth' => '1990-08-20'],
            ['email' => 'teacher3@example.com', 'code' => 'TCH-2025-0003', 'name_en' => 'Long Sopheak',   'name_kh' => 'ឡុង សុភ័ក្ត្រ',   'gender' => 'male',   'date_of_birth' => '1988-12-03'],
        ];

        foreach ($teachers as $t) {
            $user = User::where('email', $t['email'])->first();
            if (! $user) continue;

            Teacher::updateOrCreate(
                ['teacher_code' => $t['code']],
                [
                    'user_id'        => $user->id,
                    'branch_id'      => $user->branch_id,
                    'name_kh'        => $t['name_kh'],
                    'name_en'        => $t['name_en'],
                    'gender'         => $t['gender'],
                    'date_of_birth'  => $t['date_of_birth'],
                    'phone'          => $user->phone ?? '+855 12 000 100',
                    'email'          => $user->email,
                    'address'        => 'Phnom Penh, Cambodia',
                    'status'         => 'active',
                ]
            );
        }
    }
}
