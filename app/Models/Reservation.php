<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Define the relationsiop with guests
    public function guest() {
      return $this->belongsTo(Guest::class);
    }

    // Define the relationship with room reservation
    public function roomReservation() {
      return $this->hasMany(RoomReservation::class);
    }

    // Define the relationship with rooms throught room reservations
    public function rooms() {
      return $this->hasManyThrough(Rooms::class, RoomReservation::class);
    }
}