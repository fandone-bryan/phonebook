<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

use App\Group;

class GroupController extends Controller
{
    public function index()
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador possui acesso a está área!']);
        }

        $groups = Group::where('user_id', Session::get('user.id'))->get();

        return view('group.index', ['groups' => $groups]);
    }

    public function create()
    {

        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode cadastrar usuários!']);
        }

        return view('group.form');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Preencha o nome do grupo.',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->all)->withErrors($validator);
        }

        $group = new Group;

        $group->name = $request->name;
        $group->user_id = Session::get('user.id');

        $group->save();

        Session::put('message', 'Grupo cadastrado com sucesso');

        return redirect('/grupos');
    }

    public function edit($id)
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode cadastrar usuários!']);
        }

        $group = Group::find($id);

        return view('group.form', ['group' => $group]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Preencha o nome do grupo.',
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->all)->withErrors($validator);
        }

        $group = Group::find($id);

        $group->name = $request->name;

        $group->save();

        Session::put('message', 'Grupo alterado com sucesso');

        return redirect('/grupos');
    }

    public function destroy($id)
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode excluir usuários!']);
        }

        $group = Group::find($id);

        $group->delete();

        Session::put('message', 'Grupo excluído com sucesso');

        return redirect('/grupos');
    }
}
