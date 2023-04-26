<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnServices extends Model
{
    use HasFactory;

    protected $fillable = [
      'room_types_id',
      'services_id',
    ];
    
    public function roomtypes() {
      return $this->belongsTo(RoomTypes::class, 'room_types_id');
    }

    public function services() {
      return $this->belongsTo(Services::class);
    }
}