<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
      'user_types_id',
      'name',
      'email',
      'password',
      'gender',
      'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
      'password',
      'remember_token',
    ];

    public function userType() {
      return $this->belongsTo(UserTypes::class);
    }
}