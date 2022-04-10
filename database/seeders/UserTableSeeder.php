<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => Uuid::uuid6()->getHex(),
            'name' => 'Super Admin',
            'nickname' => 'SuperAdmin',
            'email' => 'myadmin@mail.test',
            'password' => bcrypt('admin')
        ]);
    }
}
