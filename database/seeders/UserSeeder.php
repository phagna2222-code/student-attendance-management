<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $main = Branch::where('code', 'MAIN')->first();
        $br2  = Branch::where('code', 'BR2')->first();
        $roles = Role::all()->keyBy('slug');

        $users = [
            ['email' => 'admin@example.com',     'username' => 'admin',     'name' => 'System Administrator', 'user_type' => 'super_admin',  'branch_id' => $main->id, 'roles' => ['super-admin']],
            ['email' => 'school@example.com',    'username' => 'school',    'name' => 'School Admin',         'user_type' => 'school_admin', 'branch_id' => $main->id, 'roles' => ['school-admin']],
            ['email' => 'secretary@example.com', 'username' => 'secretary', 'name' => 'Sok Sothy',            'user_type' => 'secretary',    'branch_id' => $main->id, 'roles' => ['secretary']],
            ['email' => 'teacher@example.com',   'username' => 'teacher',   'name' => 'Demo Teacher',         'user_type' => 'teacher',      'branch_id' => $main->id, 'roles' => ['teacher']],
            ['email' => 'teacher2@example.com',  'username' => 'teacher2',  'name' => 'Chan Dara',            'user_type' => 'teacher',      'branch_id' => $main->id, 'roles' => ['teacher']],
            ['email' => 'teacher3@example.com',  'username' => 'teacher3',  'name' => 'Long Sopheak',         'user_type' => 'teacher',      'branch_id' => $br2->id,  'roles' => ['teacher']],
            ['email' => 'parent@example.com',    'username' => 'parent',    'name' => 'Mr. Pich Pisey',       'user_type' => 'parent',       'branch_id' => $main->id, 'roles' => ['parent']],
            ['email' => 'parent2@example.com',   'username' => 'parent2',   'name' => 'Mrs. Sao Sina',        'user_type' => 'parent',       'branch_id' => $main->id, 'roles' => ['parent']],
            ['email' => 'auditor@example.com',   'username' => 'auditor',   'name' => 'Audit Reviewer',       'user_type' => 'auditor',      'branch_id' => $main->id, 'roles' => ['auditor']],
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'branch_id'         => $u['branch_id'],
                    'name'              => $u['name'],
                    'username'          => $u['username'],
                    'password'          => Hash::make('password'),
                    'user_type'         => $u['user_type'],
                    'status'            => 'active',
                    'email_verified_at' => now(),
                ]
            );

            // role_user
            $roleIds = collect($u['roles'])->map(fn ($s) => $roles[$s]?->id)->filter()->all();
            $user->roles()->syncWithoutDetaching($roleIds);

            // branch_user (default + secondary for super-admin)
            DB::table('branch_user')->updateOrInsert(
                ['branch_id' => $u['branch_id'], 'user_id' => $user->id],
                ['is_default' => true, 'created_at' => now(), 'updated_at' => now()]
            );
            if ($u['user_type'] === 'super_admin' && $br2) {
                DB::table('branch_user')->updateOrInsert(
                    ['branch_id' => $br2->id, 'user_id' => $user->id],
                    ['is_default' => false, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
