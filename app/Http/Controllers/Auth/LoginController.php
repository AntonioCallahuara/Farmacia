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
     * Mostrar el formulario de login
     */
    public function showLoginForm()
    {
        return view('modules.auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        // 1. Validar datos de entrada
        $request->validate([
            'nombre_usuario' => 'required|string',
            'contrasena' => 'required|string',
        ], [
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio',
            'contrasena.required' => 'La contraseña es obligatoria',
        ]);

        // 2. Buscar el usuario
        $usuario = Usuario::where('nombre_usuario', $request->nombre_usuario)->first();

        // 3. Verificar si el usuario existe
        if (!$usuario) {
            return back()
                ->withInput($request->only('nombre_usuario'))
                ->with('error', 'Usuario o contraseña incorrectos');
        }

        // 4. Verificar si el usuario está bloqueado
        if ($usuario->estado === 'BLOQUEADO') {
            return back()
                ->withInput($request->only('nombre_usuario'))
                ->with('error', 'Su cuenta está bloqueada. Contacte al administrador.');
        }

        // 5. Verificar si el usuario está inactivo
        if ($usuario->estado === 'INACTIVO') {
            return back()
                ->withInput($request->only('nombre_usuario'))
                ->with('error', 'Su cuenta está inactiva. Contacte al administrador.');
        }

        // 6. Verificar contraseña
        if (!Hash::check($request->contrasena, $usuario->contrasena)) {
            // Incrementar intentos fallidos
            $usuario->increment('intentos_fallidos');

            // Bloquear si supera 3 intentos
            if ($usuario->intentos_fallidos >= 3) {
                $usuario->update(['estado' => 'BLOQUEADO']);
                return back()->with('error', 'Cuenta bloqueada por demasiados intentos fallidos.');
            }

            $intentosRestantes = 3 - $usuario->intentos_fallidos;
            return back()
                ->withInput($request->only('nombre_usuario'))
                ->with('error', "Contraseña incorrecta. Le quedan {$intentosRestantes} intentos.");
        }

        // 7. Login exitoso: resetear intentos y actualizar último acceso
        $usuario->update([
            'intentos_fallidos' => 0,
            'ultimo_acceso' => now(),
        ]);

        // 8. Autenticar al usuario
        Auth::login($usuario);

        // 9. Regenerar sesión (seguridad)
        $request->session()->regenerate();

        // 10. Redirigir al dashboard
        return redirect()->route('dashboard')
                         ->with('success', '¡Bienvenido, ' . $usuario->persona->nombre . '!');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                         ->with('success', 'Sesión cerrada correctamente');
    }
}