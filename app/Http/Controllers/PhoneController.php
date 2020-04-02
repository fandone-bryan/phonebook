<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Log;
use App\Phone;
use App\Customer;
use App\Permission;
use App\GroupPermission;
use Session;

class PhoneController extends Controller
{
    public function index($customerId)
    {
        $permissions = [];
        $user = User::find(Session::get('user.id'));
        $groupPermissions = GroupPermission::where('group_id', $user->group_id)->get();
        
        foreach ($groupPermissions as $value) {
            $permissions[] = (Permission::find($value->permission_id)->toArray())['name'];
        }

        if (Session::get('user.occupation') !== 'admin' && !in_array('phone_list', $permissions)) {                   
            return response()->json(["msg" => "Permissão insuficiente!"], 403);
        }

        $phones = [];
        
        if (Session::get('user.occupation') == 'admin' || in_array('phone_list', $permissions)) {
            $phones = Phone::where('customer_id', '=', $customerId)->get();
        }
        
        $customer = Customer::find($customerId);

        $log = new Log;
        $log->description = "Acessou a lista de telefone do cliente: {$customer->id} - {$customer->name}";
        $log->user_id = $user->id;
        $log->save();

        return response()->json($phones);
    }

    public function store(Request $request)
    {
        $permissions = [];
        $user = User::find(Session::get('user.id'));
        $groupPermissions = GroupPermission::where('group_id', $user->group_id)->get();
        
        foreach ($groupPermissions as $value) {
            $permissions[] = (Permission::find($value->permission_id)->toArray())['name'];
        }

        if (Session::get('user.occupation') !== 'admin' && !in_array('phone_create', $permissions)) {                   
            return response()->json(["msg" => "Permissão insuficiente!"], 403);
        }

        $phone = new Phone;

        $phone->number = $request->number;
        $phone->customer_id = $request->customer_id;

        $phone->save();

        $customer = Customer::find($request->customer_id);

        $log = new Log;
        $log->description = "Cadastrou o telefone $request->number para o cliente: {$customer->id} - {$customer->name}";
        $log->user_id = $user->id;
        $log->save();

        return response()->json(["msg" => "ok"]);
    }

    public function update(Request $request, $id)
    {
        $permissions = [];
        $user = User::find(Session::get('user.id'));
        $groupPermissions = GroupPermission::where('group_id', $user->group_id)->get();
        
        foreach ($groupPermissions as $value) {
            $permissions[] = (Permission::find($value->permission_id)->toArray())['name'];
        }

        if (Session::get('user.occupation') !== 'admin' && !in_array('phone_edit', $permissions)) {                   
            return response()->json(["msg" => "Permissão insuficiente!"], 403);
        }

        $phone = Phone::find($id);

        $oldNumber = $phone->number;
        $customerId = $phone->customer_id;

        $phone->number = $request->number;

        $phone->save();
        $customer = Customer::find($customerId);

        $log = new Log;
        $log->description = "Alterou o telefone $oldNumber para $request->number do cliente: {$customer->id} - {$customer->name}";
        $log->user_id = $user->id;
        $log->save();
        return response()->json(["msg" => "ok"]);
    }

    public function destroy($id)
    {
        $permissions = [];
        $user = User::find(Session::get('user.id'));
        $groupPermissions = GroupPermission::where('group_id', $user->group_id)->get();
        
        foreach ($groupPermissions as $value) {
            $permissions[] = (Permission::find($value->permission_id)->toArray())['name'];
        }

        if (Session::get('user.occupation') !== 'admin' && !in_array('phone_delete', $permissions)) {                   
            return response()->json(["msg" => "Permissão insuficiente!"], 403);
        }

        $phone = Phone::find($id);

        $number = $phone->number;
        $customerId = $phone->customer_id;

        $phone->delete();

        $customer = Customer::find($customerId);
        
        $log = new Log;
        $log->description = "Excluiu o telefone $number do cliente: {$customer->id} - {$customer->name}";
        $log->user_id = $user->id;
        $log->save();

        return response()->json(["msg" => "ok"]);
    }
}
