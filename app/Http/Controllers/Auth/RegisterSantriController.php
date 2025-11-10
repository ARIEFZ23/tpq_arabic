<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterSantriController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register-santri');
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
            
            // Validasi untuk Role
            'role' => ['required', 'string', 'in:santri_putra,santri_putri'],

            // Validasi untuk Kelas
            'kelas' => ['required', 'string', 'max:255'], 

            // 1. DITAMBAHKAN: Validasi untuk Nomor Telepon (opsional)
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // Menyimpan role dari form
            'role' => $request->role, 

            // Menyimpan 'kelas' dari form sebagai 'class_id'
            'class_id' => $request->kelas,

            // 2. DITAMBAHKAN: Menyimpan 'no_telepon'
            'no_telepon' => $request->no_telepon,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}