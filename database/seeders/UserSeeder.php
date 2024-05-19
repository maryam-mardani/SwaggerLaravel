<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'administrator',
            'username' => 'administrator',
            'password' => Hash::make('123456'),
        ]);

        Schema::enableForeignKeyConstraints();
    }

}
