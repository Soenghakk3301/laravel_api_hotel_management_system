<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $fillable = [
      'room_types_id',
      'room_no',
    ];


    public function roomtype() {
      return $this->belongsTo(RoomTypes::class, 'room_types_id');
    }

    // Define the relationship with room reservations
    public function roomReservations()
    {
        return $this->hasMany(RoomReservation::class);
    }

    // Define the relationship with reservations through room bookings
    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, RoomReservation::class);
    }
}