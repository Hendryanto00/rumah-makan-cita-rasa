<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     * 
     * This method works even if user is not logged in (e.g., clicking from email).
     * It's secure because it uses signed URL validation.
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        try {
            $user = User::findOrFail($id);

            // Verify the hash matches the user's email
            if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
                return redirect('/')->with('error', 'Link verifikasi tidak valid. Silakan minta link verifikasi baru.');
            }

            // If user is not logged in, log them in first
            if (!Auth::check()) {
                Auth::login($user);
                // Regenerate session to prevent issues
                $request->session()->regenerate();
            } else {
                // If logged in as different user, logout and login as the correct user
                if (Auth::id() !== $user->id) {
                    Auth::logout();
                    Auth::login($user);
                    $request->session()->regenerate();
                }
            }

            // Check if already verified
            if ($user->hasVerifiedEmail()) {
                return redirect('/')->with('success', 'Email Anda sudah terverifikasi. Selamat datang kembali!');
            }

            // Mark email as verified
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }

            // Refresh user instance to get updated data
            $user->refresh();

            // Redirect to landing page with success message
            return redirect('/')->with('success', 'Email berhasil diverifikasi! Selamat datang di Rumah Makan Cita Rasa!');
            
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Email verification error: ' . $e->getMessage(), [
                'id' => $id,
                'hash' => $hash,
                'url' => $request->fullUrl(),
            ]);
            
            return redirect('/')->with('error', 'Terjadi kesalahan saat memverifikasi email. Silakan coba lagi atau hubungi administrator.');
        }
    }
}
