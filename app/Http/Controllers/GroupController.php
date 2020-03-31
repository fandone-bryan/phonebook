<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use App\Group;

class GroupController extends Controller
{
    public function index()
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador possui acesso a está área!']);
        }

        $groups = Group::where('user_id',Session::get('user.id'))->get();

        return view('group.index', ['groups' => $groups]);
    }
}
