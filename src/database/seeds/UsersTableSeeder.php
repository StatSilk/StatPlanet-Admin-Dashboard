<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => Crypt::encryptString('Admin'),
            'lastname' => Crypt::encryptString('Admin'),
            'email' => Crypt::encryptString('admin@gmail.com'),
            'username' => Crypt::encryptString('admin'),
            'password' => bcrypt('admin@123'),
            'role'    =>  'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
