<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        if (auth()->guard()->name == 'admin') {
            if (! Hash::check($validated['current_password'], $request->user()->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'current password is not correct',
                ]);
            }
            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
        } else {
            if ($validated['current_password'] != $request->user()->password) {
                throw ValidationException::withMessages([
                    'current_password' => 'current password is not correct',
                ]);
            }
            $request->user()->update([
                'password' => $validated['password'],
            ]);
        }

        return back()->with('success', 'password updated');
    }
}
