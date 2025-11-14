<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended('/')->with('success', 'Email Anda sudah terverifikasi.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Redirect berdasarkan role setelah verifikasi
        if ($user->role) {
            if ($user->role->name === 'admin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Email berhasil diverifikasi!');
            }
            if ($user->role->name === 'owner') {
                return redirect()->intended(route('owner.dashboard'))->with('success', 'Email berhasil diverifikasi!');
            }
        }

        return redirect()->intended('/')->with('success', 'Email berhasil diverifikasi!');
    }
}
