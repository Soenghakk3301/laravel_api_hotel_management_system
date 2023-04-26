<?php

namespace Database\Seeders;

use App\Models\Rooms;
use App\Models\RoomTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomtypes = RoomTypes::get();

        DB::table('rooms')->delete();

        foreach($roomtypes as $roomtype) 
            Rooms::factory()->count(10)->create(['room_types_id' => $roomtype->id]);
    }
}