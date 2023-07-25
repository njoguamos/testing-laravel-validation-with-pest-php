<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegistrationController
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:80'],
            'email' => ['required', 'email', 'max:100', 'unique:users'],
            'password' => ['required', Password::min(size: 8)->uncompromised(), 'max:64'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        session()->flash(
            key: 'status',
            value: __(
                key: 'messages.user.created',
                replace: ['name' => $user->name]
            )
        );

        return to_route(route: 'home');
    }
}
