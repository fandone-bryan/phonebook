<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

use App\User;
use App\Group;

class UserController extends Controller
{

    public function index()
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador possui acesso a está área!']);
        }

        $users = User::where([
            ['occupation', 'user'],
            ['admin_id', Session::get('user.id')]
        ])->get();

        foreach ($users as $key => $user) {
            $users[$key]->group = Group::find($user->group_id)->toArray();
        }
  
        return view('user.index', ['users' => $users]);
    }

    public function create()
    {
        if (empty(Group::all()->toArray())) {
            return back()->withErrors(['user_exists' => 'Para poder adicionar um usuário, cadastre ao menos um grupo!']);
        }

        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode cadastrar usuários!']);
        }

        $groups = Group::where('user_id', Session::get('user.id'))->get();

        return view('user.form', ["groups" => $groups]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'signup_email' => 'required|email',
            'password' => 'required',
        ], [
            'name.required' => 'Preencha seu nome.',
            'signup_email.required' => 'Preencha seu e-mail',
            'signup_email.email' => 'E-mail inválido',
            'password.required' => 'Preencha sua senha'
        ]);

        if ($validator->fails()) {
            $request->session()->put('form', 'signup');
            return back()->withInput($request->all)->withErrors($validator);
        }

        $userExists = (User::where('email', $request->signup_email)->get())->toArray();

        if ($userExists) {
            $request->session()->put('form', 'signup');

            return back()->withInput($request->all)->withErrors(['user_exists' => 'E-mail já cadastrado']);
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->signup_email;
        $user->password = Hash::make($request->password);
        $user->occupation = $request->occupation;
        $user->group_id = $request->group_id;

        $user->admin_id = !empty($request->session()->get('user')) ? $request->session()->get('user.id') : null;

        $user->save();

        if ($user->admin_id !== null) {
            Session::put('message', 'Usuário cadastrado com sucesso');
            return redirect('/usuarios');
        }

        $request->session()->forget('form');

        $request->session()->put('user.id', $user->id);
        $request->session()->put('user.name', $user->name);
        $request->session()->put('user.email', $user->email);
        $request->session()->put('user.occupation', $user->occupation);


        return redirect('/');
    }


    public function edit($id)
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode cadastrar usuários!']);
        }

        $user = User::find($id);

        $groups = Group::where('user_id', Session::get('user.id'))->get();

        return view('user.form', ['user' => $user, "groups" => $groups]);
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $user->name = $request->name;

        if ($user->email != $request->signup_email) {

            $emailExists = User::where([
                ['email', $request->signup_email],
            ])->get()->toArray();

            if (!empty($emailExists)) {
                return back()->withErrors(['user_exists' => 'Este e-mail já esta vinculado a outro usuário!']);
            }

            $user->email = $request->signup_email;
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->group_id = $request->group_id;
        $user->save();

        Session::put('message', 'Usuário alterado com sucesso');

        return redirect('/usuarios');
    }

    public function destroy($id)
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode excluir usuários!']);
        }

        $user = User::find($id);

        $user->delete();

        Session::put('message', 'Usuário excluído com sucesso');

        return redirect('/usuarios');
    }
}
