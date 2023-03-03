<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request) {
        try {
            // validated
            $validateUser = Validator::make($request->all(), 
            [
                'nom' => 'required',
                'prenom' => 'required',
                'username' => 'required|string|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    "success" => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'client',

            ]);

            return response()->json([
                "success" => true,
                'user' => $user,
                'message' => 'User Created Successfully',
                'access_token' => $user->createToken('API TOKEN')->plainTextToken
            ]); // 200 par défaut
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request) {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                //'username' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    "success" => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    "success" => false,
                    'message' => 'Email & Password does not match with our record',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                "success" => true,
                'user' => $user,
                'message' => 'User Logged In Successfully',
                'access_token' => $user->createToken('API TOKEN')->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
