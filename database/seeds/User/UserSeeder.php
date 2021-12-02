<?php

use App\Domains\User\UserEloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert user table records
        DB::table('users')->insert([
            ['username' => 'super.admin.system', 'email' => 'super.admin.system@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],
            ['username' => 'admin.system', 'email' => 'admin.system@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],

            ['username' => 'admin.company', 'email' => 'admin.company@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],
            ['username' => 'owner.company', 'email' => 'owner.company@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],
            ['username' => 'manager.company', 'email' => 'manager.company@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],
            ['username' => 'operator.company', 'email' => 'operator.company@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],

            ['username' => 'user.applicant', 'email' => 'user.applicant@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],
        ]);

        factory(UserEloquent::class, 2)->create();

        DB::table('users')->insert([
            ['username' => 'admin.developer', 'email' => 'admin.developer@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],
        ]);

        DB::table('users')->insert([
            ['username' => 'demo', 'email' => 'demo@gmail.com', 'password' => \Hash::make('12345'), 'is_active' => 1, 'created_by' => 'system'],
        ]);
    }
}
