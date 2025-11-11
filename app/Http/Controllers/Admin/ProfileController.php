<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\ActivityLogger;

class ProfileController extends Controller
{
    /**
     * Display the admin's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the admin's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $original = [
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'phone' => $request->user()->phone ?? null,
            'address' => $request->user()->address ?? null,
        ];

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Log activity
        $changes = [];
        foreach (['name','email','phone','address'] as $field) {
            if ($request->user()->wasChanged($field)) {
                $changes[] = $field;
            }
        }
        if (!empty($changes)) {
            ActivityLogger::log(
                'Ubah Profil Admin',
                'users',
                $request->user()->id,
                sprintf('Mengubah profil admin: %s.', implode(', ', $changes))
            );
        }

        return Redirect::route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}

