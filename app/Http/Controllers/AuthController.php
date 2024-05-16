<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use \stdClass;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname_p' => 'required|string|max:255',
            'lastname_m' => 'string|max:255',
            'birthdate' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'lastname_p' => $request->lastname_p,
            'lastname_m' => $request->lastname_m,
            'age' => $request->age,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'token_type' =>'Bearer'
        ]);
    }

    public function login(Request $request) {
        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return view('dashboard');

        // return response()->json([
        //     'message'=> 'Inició sesión con usuario '.$user->name,
        //     'accessToken' => $token,
        //     'token_type' => 'Bearer',
        //     'user' => $user
        // ]);
    }

    public function logout(Request $request) {
        $user = Auth::user();
        PersonalAccessToken::where('tokenable_id', $user->id)->delete();

        return view('dashboard');

        // return response()->json([
        //     'message' => 'Sesión cerrada exitosamente'
        // ]);
    }
}
