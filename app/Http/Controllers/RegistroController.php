<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function create()
    {
        return view('registro.create');
    }

    public function store(Request $request)
    {
        //pegando todos os dados menos o token
        $data = $request->except('_token');

        //protegendo a senha do usuário
        $data['password'] = Hash::make($data['password']);

        //criando um novo usuário
        $user = User::create($data);

        //efetuando o login
        Auth::login($user);

        return redirect()->route('listar_series');
    }
}
