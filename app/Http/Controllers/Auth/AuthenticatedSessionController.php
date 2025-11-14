<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        $user = $request->user();
        
        // Jika belum verifikasi, cek apakah user datang dari verification link
        // Jika ada intended URL (misalnya dari verification link), gunakan itu
        // Jika tidak, arahkan ke halaman verifikasi
        if (! $user->hasVerifiedEmail() && ! $request->expectsJson()) {
            $intended = $request->session()->get('url.intended');
            // Jika intended URL adalah verification link, biarkan user verifikasi dulu
            if ($intended && strpos($intended, 'verify-email') !== false) {
                // Jangan pull, biarkan intended URL tetap ada untuk redirect setelah verifikasi
                return redirect($intended);
            }
            // Jika tidak, arahkan ke halaman verifikasi
            return redirect()->route('verification.notice');
        }

        // Redirect berdasarkan role
        if ($user->role) {
            if ($user->role->name === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            if ($user->role->name === 'owner') {
                return redirect()->intended(route('owner.dashboard'));
            }
        }

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
