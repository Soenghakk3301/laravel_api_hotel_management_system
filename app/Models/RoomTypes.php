<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTypes extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'main_description',
      'sub_description',
      'bed_type',
      'price',
      'room_size',
      'floor',
      'num_guest',
    ];

    public function image() {
      return $this->hasMany(Images::class);
    }

    public function addOnServices() {
      return $this->hasMany(AddOnServices::class);
    }
}