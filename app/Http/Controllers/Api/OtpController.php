<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function request(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $ipHash = hash('sha256', config('app.key') . $request->ip());
        
        // Rate limiting: 5 requests per hour per IP/email
        $key = 'otp-request:' . $ipHash . ':' . $email;
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => ["Demasiadas tentativas. Tente novamente em " . ceil($seconds / 60) . " minutos."],
            ]);
        }

        RateLimiter::hit($key, 3600); // 1 hour

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => explode('@', $email)[0]]
        );

        // Store hashed code and expiration
        $user->update([
            'otp_code' => hash('sha256', config('app.key') . $code),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send email (simplified - would use Mail facade with template)
        try {
            Mail::raw(
                "Seu código de acesso MOBIV é: {$code}\n\nEste código expira em 10 minutos.\n\nSe não solicitou este código, ignore este e-mail.",
                function ($message) use ($email) {
                    $message->to($email)
                        ->from('imoveis@grupomobiv.pt', 'MOBIV Imóveis')
                        ->subject('Código de Acesso MOBIV');
                }
            );
        } catch (\Exception $e) {
            // Log error but don't expose to user
            \Log::error('OTP email failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Código enviado para o seu e-mail.',
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $email = $request->email;
        $code = $request->code;
        $ipHash = hash('sha256', config('app.key') . $request->ip());
        
        // Rate limiting: 5 attempts per 15 minutes
        $attemptKey = 'otp-verify:' . $ipHash . ':' . $email;
        
        if (RateLimiter::tooManyAttempts($attemptKey, 5)) {
            throw ValidationException::withMessages([
                'code' => ['Demasiadas tentativas falhadas. Tente novamente em 15 minutos.'],
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !$user->otp_code || !$user->otp_expires_at) {
            RateLimiter::hit($attemptKey, 900); // 15 minutes
            throw ValidationException::withMessages([
                'code' => ['Código inválido ou expirado.'],
            ]);
        }

        // Check expiration
        if (now()->isAfter($user->otp_expires_at)) {
            $user->update(['otp_code' => null, 'otp_expires_at' => null]);
            throw ValidationException::withMessages([
                'code' => ['Código expirado. Solicite um novo código.'],
            ]);
        }

        // Verify code
        $hashedCode = hash('sha256', config('app.key') . $code);
        
        if (!hash_equals($user->otp_code, $hashedCode)) {
            RateLimiter::hit($attemptKey, 900); // 15 minutes
            throw ValidationException::withMessages([
                'code' => ['Código inválido.'],
            ]);
        }

        // Clear OTP
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        // Clear rate limiters
        RateLimiter::clear($attemptKey);

        // Create token (Sanctum)
        $token = $user->createToken('otp-login')->plainTextToken;

        return response()->json([
            'message' => 'Autenticação bem-sucedida.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
