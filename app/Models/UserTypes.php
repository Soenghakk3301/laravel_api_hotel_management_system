<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_type_name'
    ];

    public const IS_ADMIN = 1;
    public const IS_STUFF = 2;
    public const IS_USER = 3;

    public function user()
    {
        return $this->hasMany(Users::class);
    }
}