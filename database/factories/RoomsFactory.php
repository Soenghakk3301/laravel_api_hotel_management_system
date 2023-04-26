<?php

namespace Database\Factories;

use App\Models\RoomTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rooms>
 */
class RoomsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'room_types_id' => '',
            'room_no' => fake()->unique(1)->text(5),
        ];
    }
}