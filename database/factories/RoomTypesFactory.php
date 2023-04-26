<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomTypes>
 */
class RoomTypesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            $roomtype = ['Master Room', 'Prime Room', 'Family Room', 'Standarn Room', 'Deluex Room', 'Executive Room', 'Ocean View room', 'Honeymoon Room'];
            $bedtype = ['single bed', 'double bed', 'triple bed'];
            $floor = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'];
            $price = [200, 300, 400, 500, 600];
         
            return [
               'name' => fake()->unique(0)->randomElement($roomtype),
               'main_description' => fake()->text(50),
               'sub_description' => fake()->text(50),
               'bed_type' => fake()->randomElement($bedtype),
               'price' => fake()->randomElement($price),
               'room_size' => fake()->numberBetween(50, 100),
               'floor' => fake()->randomElement($floor),
               'num_guest' => fake()->randomElement([2, 3, 5]), 
            ];
    }
}