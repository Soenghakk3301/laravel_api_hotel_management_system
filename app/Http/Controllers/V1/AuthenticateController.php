<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\RegisterRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{

   use HttpResponses;
   /**
    * Handle an authentication register attempt.
    */
    public function register(RegisterRequest $request) 
    {  
      
      $request->validated($request->all());

      $user = User::create([
         'user_types_id' => $request->user_types_id,
         'name' => $request->name,
         'email' => $request->email,
         'phone_number' => $request->phone_number,
         'gender' => $request->gender,
         'password' => Hash::make($request->password)
      ]);

      return $this->success([
         'user' => $user,
         'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken,
      ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function login(Request $request) {
      $request->validate([
         'email' => 'required|email',
         'password' => 'required',
      ]);
  
      
      if(!Auth::attempt($request->only(['email', 'password']))) 
         return $this->error('', 'Credentials do not match', 401);
      
      $user = User::where('email', $request->email)->first();

       return $this->success([
         'user' => $user,
         'token' => $user->createToken('Api of token ' . $user->name)->plainTextToken,
      ]);
   }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
      auth()->user()->tokens()->delete();

      return $this->success([
         'message' => 'You have successfully been logout and your token has been deleted.'
      ]);
    }
}