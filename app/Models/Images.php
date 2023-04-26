<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;


    protected $fillable = [
      'room_types_id',
      'image_cover_url',
      'image_url_1',
      'image_url_2',
      'image_url_3',
      'image_url_4',
    ];

    public function roomtype() {
      return $this->belongsTo(RoomTypes::class, 'room_types_id');
    }
}