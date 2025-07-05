<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        $usuario = Usuario::where('correo', $credentials['correo'])
            ->where('activo', true)
            ->first();

        if ($usuario && Hash::check($credentials['password'], $usuario->password)) {
            Auth::login($usuario, $request->boolean('remember'));
            
            // Actualizar último acceso
            $usuario->update(['ultimo_acceso' => now()]);

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', '¡Bienvenido al panel de administración!');
        }

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('correo');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vacantes.index')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}
