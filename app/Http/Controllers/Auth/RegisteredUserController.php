<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable','string','max:20'],
            'address' => ['nullable','string','max:1000'],
        ]);

        // Regenerate session SEBELUM login untuk mencegah page expired
        $request->session()->regenerate();
        
        // Ambil role 'user'
        $userRole = Role::where('name', 'user')->first();
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $userRole?->id,
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        // Login user dengan session yang sudah di-regenerate
        Auth::login($user);

        // Regenerate CSRF token setelah login untuk sinkronisasi
        $request->session()->regenerateToken();

        // KIRIM EMAIL VERIFIKASI - Menggunakan method sendEmailVerificationNotification()
        // Email verifikasi akan dikirim dengan template default Laravel
        // Untuk mengubah kata-kata email, lihat di: vendor/laravel/framework/src/Illuminate/Auth/Notifications/VerifyEmail.php
        // Atau buat custom notification di: app/Notifications/VerifyEmail.php
        $user->sendEmailVerificationNotification();

        // Redirect langsung ke verification notice tanpa intended untuk menghindari session issues
        return redirect()->route('verification.notice');
    }
}
