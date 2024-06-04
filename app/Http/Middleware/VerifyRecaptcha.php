<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptcha = new Client();
        $recaptchaSecret = config('services.recaptcha.secret_key');

        $response = $recaptcha->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $recaptchaSecret,
                'response' => $recaptchaResponse,
            ],
        ]);

        $responseBody = json_decode((string)$response->getBody());

        if (!$responseBody->success || $responseBody->score < 0.5) {
            return redirect()->back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed, please try again.']);
        }

        return $next($request);
    }
}
