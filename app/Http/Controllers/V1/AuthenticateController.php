<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\RegisterRequest;
use App\Services\AuthenicateService;
use Illuminate\Support\Facades\Auth;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticateController extends Controller
{
   /**
    * Handle an authentication register attempt.
    */
    public function register(RegisterRequest $request, AuthenicateService $authenicateService) 
    {  
      // create user + validate all incoming data
      $user = $authenicateService->createUser($request->validated($request->all()));


      $token = $user->createToken($request->auth_token)->plainTextToken;

      return response()->json([
         'status' => 'success',
         'data' => [
            'user' => $user,
         ],
         'token' => $token,
      ], 201);
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
         'device_name' => 'required',
      ]);
  
      $user = Users::where('email', $request->email)->first();
   
      if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
               'email' => ['The provided credentials are incorrect.'],
            ]);
      }
   
      $token = $user->createToken($request->user()->name)->plainTextToken;

      return $this->respondWithToken($token);
   }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
         $request->user()->currentAccessToken()->delete();

         return response()->json(['message' => 'Logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }


    public function generateToken()
    {

    }
}