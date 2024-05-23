<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
            'phone' => 'required'
        ]);

        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'lastname_p' => $request->lastname_p,
            'lastname_m' => $request->lastname_m,
            'age' => $request->age,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login');
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()->withErrors(['message' => 'Ocurrió un error al iniciar sesión']);
        } //*hash check puede ser otra opción

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return redirect()->route('dashboard')->with('token', $token);
    }

    public function logout(Request $request) {
        $user = Auth::user();
        PersonalAccessToken::where('tokenable_id', $user->id)->delete();

        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente');
    }
}
