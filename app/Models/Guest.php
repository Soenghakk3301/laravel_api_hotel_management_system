<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;


    protected $fillable = [
      'name',
      'isMale',
      'email',
      'phoneNumber',
    ];

    public function reservation() {
      return $this->hasMany(Reservation::class);
    }
}