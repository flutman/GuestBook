<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            'name' => 'admin',
//            'email' => 'admin@yan.ru',
//            'password' => bcrypt('12346'),
//        ]);
        User::truncate();
        $adminRole = Role::where('name','admin')->first();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@yan.ru',
            'password' => bcrypt('123456')
        ]);

        $admin->roles()->attach($adminRole);


    }
}
