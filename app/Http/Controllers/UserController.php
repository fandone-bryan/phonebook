<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use Illuminate\Support\Facades\Validator;
use Session;

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

        return view('user.index', ['users' => $users]);
    }

    public function create()
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode cadastrar usuários!']);
        }

        return view('user.form');
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
