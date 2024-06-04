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
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Closure;
use Illuminate\Console\View\Components\Secret;
use Illuminate\Support\Facades\Http;

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
            'g-recaptcha-response' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                $g_response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $value,
                    'remoteip' => \request()->ip()
                ]);
                if (!$g_response->json('success')) {
                    $fail("The {$attribute} is invalid.");
                }
            },]
        ]);

        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $verificationCode = random_int(1000, 9999);

        $user = User::create([
            'name' => $request->name,
            'lastname_p' => $request->lastname_p,
            'lastname_m' => $request->lastname_m,
            'age' => $request->age,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode
        ]);

        Mail::to($user->email)->send(new VerificationMail($verificationCode));
        return redirect()->route('verification.notice', ['email' => $user->email]);
    }

    public function verify(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|numeric|digits:4',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->verification_code !== $request->verification_code) {
            return redirect()->back()->withErrors(['verification_code' => 'Código de verificación incorrecto.']);
        }

        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->active = true;
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Correo verificado exitosamente');
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

        if($user->active) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return redirect()->route('dashboard')->with('token', $token);
        } else {
            return redirect()->route('verification.notice');
        }
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente');
    }
}
