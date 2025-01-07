<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //"superadmin", "user", "manager", "staff", "admin"
        $users = [
            [
               'name'=>'SuperAdmin User',
               'email'=>'superadmin@mydailybill.com',
               'usertype'=>'superadmin',
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'Manager User',
               'email'=>'manager@mydailybill.com',
               'usertype'=> 'manager',
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'User',
               'email'=>'user@mydailybill.com',
               'usertype'=>'user',
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'Staff',
               'email'=>'staff@mydailybill.com',
               'usertype'=>'staff',
               'password'=> bcrypt('123456'),
            ],
            [
               'name'=>'Admin',
               'email'=>'admin@mydailybill.com',
               'usertype'=>'admin',
               'password'=> bcrypt('123456'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
