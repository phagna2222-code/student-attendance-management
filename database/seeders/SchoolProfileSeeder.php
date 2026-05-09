<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\SchoolProfile;
use Illuminate\Database\Seeder;

class SchoolProfileSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Branch::all() as $branch) {
            SchoolProfile::updateOrCreate(
                ['branch_id' => $branch->id],
                [
                    'school_name_kh' => 'សាលា SAMS — '.$branch->name_kh,
                    'school_name_en' => 'SAMS School — '.$branch->name_en,
                    'logo_path'      => null,
                    'seal_path'      => null,
                    'signature_path' => null,
                    'phone'          => $branch->phone,
                    'email'          => $branch->email,
                    'website'        => $branch->website,
                    'address'        => $branch->address,
                ]
            );
        }
    }
}
