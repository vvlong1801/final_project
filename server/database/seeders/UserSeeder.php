<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Account;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::factory()->count(1)->state([
            'name' => 'admin',
            'email' => 'superAdmin@admin.com',
        ])->for(Account::factory()->state(['role' => Role::superAdmin]))->create();

        $admin = User::factory()->count(1)->state([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ])->for(Account::factory()->state(['role' => Role::admin]))->create();

        $members = Member::factory()->state(['user_id' => User::factory()->hasAvatar(1)])->count(3)->create();
    }
}
