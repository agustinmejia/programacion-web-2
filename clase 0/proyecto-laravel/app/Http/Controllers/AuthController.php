<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // Procesa las credenciales del formulario
    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            return redirect()->intended(route('estudiantes.index'));
        }

        return back()
            ->withErrors(['email' => 'Email o contraseña incorrectos.'])
            ->onlyInput('email');
    }

    // Cierra la sesión
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
