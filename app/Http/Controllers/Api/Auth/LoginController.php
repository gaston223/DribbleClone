<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function attemptLogin(Request $request)
    {
        // * attempt to issue to the user based ont the login credentials
        $token = $this->guard()->attempt($this->credentials($request));

        if (! $token) {
            return false;
        }
        // * Get the authenticated user
        $user = $this->guard()->user();

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return false;
        }

        // * set the user's token
        $this->guard()->setToken($token);

        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        // * set the token from the authentication guard (JWT)
        $token = (string) $this->guard()->getToken();

        // * extract the expiry date of token
        $expiration = $this->guard()->getPayload()->get('exp');

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $this->guard()->user();
        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return response()->json([
                'errors' => 'You need to verify your email account',
            ]);
        }
        throw ValidationException::withMessages([
            $this->username() => 'Authentication failed',
        ]);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'message' => 'logged out successfully!',
        ]);
    }
}
