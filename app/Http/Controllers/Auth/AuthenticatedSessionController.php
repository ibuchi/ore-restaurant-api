<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        return Response::api([
            'message' => 'Login successful!',
            'data' => $request->user(),
            'token' => Auth::user()->token['value'],
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        user()->tokens()->delete();

        Auth::guard('web')->logout();

        return Response::api([
            'message' => 'Logout successful!',
        ]);
    }
}
