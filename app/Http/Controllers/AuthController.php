<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    // 1. Mostrar login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. Mostrar registro
    public function showRegister()
    {
        return view('auth.register');
    }

    
    // 3. Registrar usuario
public function register(Request $request)
{
    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6'
    ]);

    // Si no existe ningún usuario en la tabla → el primero será admin
    $role = User::count() === 0 ? 'admin' : 'user';

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $role,
    ]);

    return redirect('/login')->with('success', 'Cuenta creada. Iniciá sesión.');
}


    
    // 4. Iniciar sesión
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            return redirect('/')->with('success', '¡Bienvenido!');
        }

        return back()->withErrors(['email' => 'Datos incorrectos'])->withInput();
    }

    
    // 5. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
