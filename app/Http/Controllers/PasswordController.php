<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use Session;

class PasswordController extends Controller
{
    public function edit($id)
    {
        return view('user.form-edit');
    }

    public function update(Request $request, $id)
    {
        /**
         * Id do usuário sempre sendo pego pela sessão,
         * pois por mais que mudem o id na url, não irão
         * alterar a senha de outro usuário que não seja
         * o seu próprio.
         */
        $user = User::find($request->session()->get('user.id'));

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withInput($request->all())->withErrors(['msg' => 'A senha antiga não está correta!']);
        }

        if ($request->new_password !== $request->re_new_password) {
            return back()->withInput($request->all())->withErrors(['msg' => 'As senhas não coincidem!']);
        }

        $user->password = Hash::make($request->new_password);

        $user->save();

        return view('user.form-edit', ['success' => true]);
    }
}
