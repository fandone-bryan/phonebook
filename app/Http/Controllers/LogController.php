<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Log;
use App\User;
use App\GroupPermission;
use App\Permission;
use Session;

class LogController extends Controller
{
    public function index()
    {
        $permissions = [];
        $user = User::find(Session::get('user.id'));
        $groupPermissions = GroupPermission::where('group_id', $user->group_id)->get();

        foreach ($groupPermissions as $value) {
            $permissions[] = (Permission::find($value->permission_id)->toArray())['name'];
        }

        if (Session::get('user.occupation') !== 'admin' && !in_array('logs_all', $permissions)) {
            $logs = Log::where('user_id', $user->id)->get()->toArray();
        } else {
            $logs = Log::all()->toArray();
        }
        $novo = [];
        if (!empty($logs)) {
            $novo = array_map(function ($value) {
                $user = User::find($value["user_id"]);
                $value["user_name"] = $user->name;
                return $value;
            }, $logs);
        }

        return view('log.index', ["logs" => $novo]);
    }
}
