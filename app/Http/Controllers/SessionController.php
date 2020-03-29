<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $request->session()->put('form', 'signin');

        $validator = Validator::make($request->all(), [
            'signin_email' => 'required|email',
            'password' => 'required',
        ], [            
            'signin_email.required' => 'Preencha seu e-mail',
            'signin_email.email' => 'E-mail inválido',
            'password.required' => 'Preencha sua senha'
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->all())->withErrors($validator);
        }
        
        $user = User::where('email', $request->signin_email)->first();

        if (!$user) {
            return back()->withInput($request->all())->withErrors(['msg' => 'Este usuário não existe!']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withInput($request->all())->withErrors(['msg' => 'Senha inválida!']);
        }
        
        $request->session()->forget('form');

        $request->session()->put('user.id', $user->id);
        $request->session()->put('user.name', $user->name);
        $request->session()->put('user.email', $user->email);
        $request->session()->put('user.occupation', $user->occupation);
        
        return redirect('/');
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('user');

        return redirect('/login');
    }
}
