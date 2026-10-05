<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Mostra a tela de login
    public function index()
    {
        return view('auth.login');
    }

    // 2. Processa o formulário de login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta fazer o login com os dados fornecidos
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirecionamento inteligente baseado no "Cargo" (Role)
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($role === 'treinador') {
                return redirect('/treinador');
            }

            // Se for atleta, vai para a visão mobile (que faremos depois)
            return redirect('/app');
        }

        // Se errar a senha, volta para o login com erro
        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    // 3. Faz o logout e destrói a sessão
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Método para processar a troca de senha
    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // 'confirmed' exige o campo new_password_confirmation
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        // Verifica se a senha atual está correta
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        // Atualiza para a nova senha
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return back()->with('success_password', 'Senha alterada com sucesso!');
    }
}
