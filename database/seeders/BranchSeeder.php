<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'MAIN', 'name_en' => 'Main Campus',     'name_kh' => 'សាខាមេ',    'phone' => '+855 23 000 000', 'email' => 'main@example.com', 'website' => 'https://example.com', 'address' => 'Phnom Penh, Cambodia', 'is_main' => true,  'status' => 'active'],
            ['code' => 'BR2',  'name_en' => 'Siem Reap Campus','name_kh' => 'សាខាសៀមរាប', 'phone' => '+855 23 000 001', 'email' => 'br2@example.com',  'website' => null,                  'address' => 'Siem Reap, Cambodia',  'is_main' => false, 'status' => 'active'],
            ['code' => 'BR3',  'name_en' => 'Battambang Campus','name_kh' => 'សាខាបាត់ដំបង','phone' => '+855 23 000 002', 'email' => 'br3@example.com', 'website' => null,                  'address' => 'Battambang, Cambodia', 'is_main' => false, 'status' => 'active'],
        ];

        foreach ($rows as $r) {
            Branch::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
