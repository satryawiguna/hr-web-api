<?php

use App\Domains\User\Profile\ProfileEloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            ['user_id' => 1, 'full_name' => 'Super Admin System', 'nick_name' => 'Super Admin', 'email' => 'superadmin_system@gmail.com'],
            ['user_id' => 2, 'full_name' => 'Admin System', 'nick_name' => 'Admin', 'email' => 'admin_system@gmail.com'],

            ['user_id' => 3, 'full_name' => 'Admin Company', 'nick_name' => 'Admin', 'email' => 'admin_company@gmail.com'],
            ['user_id' => 4, 'full_name' => 'Owner Company', 'nick_name' => 'Owner', 'email' => 'owner_company@gmail.com'],
            ['user_id' => 5, 'full_name' => 'Manager Company', 'nick_name' => 'Manager', 'email' => 'manager_company@gmail.com'],
            ['user_id' => 6, 'full_name' => 'Operator Company', 'nick_name' => 'Operator', 'email' => 'operator_company@gmail.com'],
        ]);

        factory(ProfileEloquent::class, 4)->create();
    }
}
