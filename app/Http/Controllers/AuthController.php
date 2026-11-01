<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/homepage');
        }
        return view('auth.login');
    }

    /**
     * Handle conventional login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check roles and set success messages
            if ($user->role === 'admin') {
                return redirect()->intended('/homepage')->with('success', 'Selamat datang kembali, Admin ' . $user->name . '!');
            }

            return redirect()->intended('/homepage')->with('success', 'Halo ' . $user->name . ', Anda berhasil masuk!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/homepage');
        }
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // default role
        ]);

        Auth::login($user);

        return redirect('/homepage')->with('success', 'Pendaftaran berhasil! Selamat datang ' . $user->name . '!');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret) || $clientId === 'YOUR_GOOGLE_CLIENT_ID' || $clientSecret === 'YOUR_GOOGLE_CLIENT_SECRET') {
            return redirect()->route('login')->with('warning', 'Google Login belum dikonfigurasi. Harap lengkapi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di file .env Anda.');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal menghubungkan ke Google: ' . $e->getMessage());
        }
    }

    /**
     * Handle Google OAuth Callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Proses Login Google dibatalkan atau terjadi kesalahan.');
        }

        // Check if the user already exists by google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            // Check if user already exists by email (and link them to google)
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Register a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => 'user',
                ]);
            }
        }

        Auth::login($user, true);

        return redirect('/homepage')->with('success', 'Selamat datang ' . $user->name . ', Anda berhasil masuk menggunakan Google!');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/homepage')->with('success', 'Anda telah berhasil keluar.');
    }
}
