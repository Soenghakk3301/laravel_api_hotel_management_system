<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    public function roomReservation() {
      return $this->belongsTo(RoomReservation::class);
    }

    public function guest() {
      return $this->belongsTo(Guest::class);
    }
}