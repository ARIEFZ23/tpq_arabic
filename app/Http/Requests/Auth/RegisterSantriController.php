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
     * Display the registration form for santri.
     */
    public function create(): View
    {
        return view('auth.register-santri');
    }

    /**
     * Handle an incoming registration request for santri.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'jenis_kelamin' => ['required', 'in:putra,putri'],
            'kelas' => ['required', 'string', 'max:50'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
            'kelas.required' => 'Kelas wajib dipilih',
        ]);

        // Tentukan role berdasarkan jenis kelamin
        $role = $request->jenis_kelamin === 'putra' ? 'santri_putra' : 'santri_putri';

        // Buat user baru dengan default level system values
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'class_id' => $request->kelas,
            'no_telepon' => $request->no_telepon,
            // Default level system values
            'level' => 1,
            'experience_points' => 0,
            'total_score' => 0,
            'games_completed' => 0,
        ]);

        // Fire registered event
        event(new Registered($user));

        // Login user otomatis setelah registrasi
        Auth::login($user);

        // Redirect ke santri dashboard
        return redirect()->route('santri.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di TPQ Arabic Learning! 🎉');
    }
}