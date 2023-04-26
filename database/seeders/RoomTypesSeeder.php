<?php

namespace Database\Seeders;

use App\Models\RoomTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    

    public function run()
    {
      // DB::table('room_types')->delete();

      RoomTypes::factory(8)->create();
    }
}