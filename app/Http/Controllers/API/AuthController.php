<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        $token = $user->createToken('MyToken')->plainTextToken;
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully logged in',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user =  $request->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully logged out'
        ], 200);
    }
}
