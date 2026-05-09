<?php

namespace Database\Seeders;

use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['email' => 'parent@example.com',  'parent_code' => 'PRN-0001', 'name_en' => 'Pich Pisey',   'name_kh' => 'ពេជ្រ ពិសី',   'gender' => 'male',   'phone' => '+855 12 000 200', 'secondary_phone' => null,                'telegram_chat_id' => null],
            ['email' => 'parent2@example.com', 'parent_code' => 'PRN-0002', 'name_en' => 'Sao Sina',     'name_kh' => 'សៅ ស៊ីណា',     'gender' => 'female', 'phone' => '+855 12 000 201', 'secondary_phone' => '+855 96 000 201',  'telegram_chat_id' => null],
            ['email' => null,                  'parent_code' => 'PRN-0003', 'name_en' => 'Sok Bopha',    'name_kh' => 'សុខ បុប្ផា',  'gender' => 'female', 'phone' => '+855 12 000 202', 'secondary_phone' => null,                'telegram_chat_id' => null],
            ['email' => null,                  'parent_code' => 'PRN-0004', 'name_en' => 'Mao Sothea',   'name_kh' => 'ម៉ៅ សុធា',     'gender' => 'male',   'phone' => '+855 12 000 203', 'secondary_phone' => null,                'telegram_chat_id' => null],
        ];

        foreach ($rows as $r) {
            $userId = $r['email'] ? optional(User::where('email', $r['email'])->first())->id : null;
            StudentParent::updateOrCreate(
                ['parent_code' => $r['parent_code']],
                [
                    'user_id'           => $userId,
                    'name_kh'           => $r['name_kh'],
                    'name_en'           => $r['name_en'],
                    'gender'            => $r['gender'],
                    'phone'             => $r['phone'],
                    'secondary_phone'   => $r['secondary_phone'],
                    'email'             => $r['email'],
                    'telegram_chat_id'  => $r['telegram_chat_id'],
                    'address'           => 'Phnom Penh, Cambodia',
                    'status'            => 'active',
                ]
            );
        }
    }
}
