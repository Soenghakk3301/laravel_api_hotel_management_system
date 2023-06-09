<?php

namespace Database\Seeders;

use App\Models\UserTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserTypes::create(['user_type_name' => 'Admin']);
        UserTypes::create(['user_type_name' => 'Stuff']);
        UserTypes::create(['user_type_name' => 'User']);
    }
}