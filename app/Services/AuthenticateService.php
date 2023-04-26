<?php 

namespace App\Services;

use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class AuthenicateService {
   public function createUser(array $userData): Users
    {

      // 'user_types_id',
      // 'name',
      // 'email',
      // 'password',
      // 'gender',
      // 'phone_number'

        $user = Users::create([
            'user_types_id' => $userData['user_types_id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'gender' => $userData['gender'],
            'phone_number' => $userData['phone_number'],
        ]);

        return $user;
    }
}