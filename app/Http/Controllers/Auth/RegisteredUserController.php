<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        // Ambil organization dari query string
        $organization = null;
        if ($request->has('organization_id')) {
            $organization = Organization::find($request->organization_id);
        }

        return view('auth.register', compact('organization'));
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^[1-9][0-9]{7,15}$/'],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'organization_id' => ['required', 'exists:organizations,id'],
        ]);

        // Validasi tambahan: organization harus benar-benar ada
        $organization = Organization::find($request->organization_id);
        if (!$organization) {
            return redirect()->back()->withErrors(['organization_id' => 'Organisasi tidak ditemukan.']);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'organization_id' => $organization->id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
