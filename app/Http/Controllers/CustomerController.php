<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Customer;
use App\GroupPermission;
use App\Permission;
use App\Phone;
use App\User;
use Session;
use DB;

class CustomerController extends Controller
{
    public function index()
    {
        $permissions = [];

        if (Session::get('user.occupation') != 'admin') {
            
            $user = User::find(Session::get('user.id'));

            $admin = User::find($user->admin_id);

            $customer = Customer::where('user_id', $admin->id)->get();            

            $groupPermissions = GroupPermission::where('group_id', $user->group_id)->get();
            
            foreach ($groupPermissions as $value) {
                $permissions[] = (Permission::find($value->permission_id)->toArray())['name'];
            }
        } else {
            $customer = Customer::where('user_id', Session::get('user.id'))->get();
        }

        return view('customer.index', ['customers' => $customer, 'permissions' => $permissions]);
    }

    public function create()
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode cadastrar clientes!']);
        }

        return view('customer.form');
    }

    public function store(Request $request)
    {
        if (Session::get('user.occupation') !== 'admin') {
            return back()->withErrors(['user_exists' => 'Somente o administrador pode cadastrar clientes!']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Preencha seu nome.',
            'email.required' => 'Preencha seu e-mail',
            'email.email' => 'E-mail inválido'
        ]);

        if ($validator->fails()) {
            return back()->withInput($request->all)->withErrors($validator);
        }

        $customerExists = (Customer::where('email', $request->email)->get())->toArray();

        if ($customerExists) {
            return back()->withInput($request->all)->withErrors(['user_exists' => 'E-mail já cadastrado']);
        }

        $customer = new Customer();

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->user_id = Session::get('user.id');

        $customer->save();

        return redirect('/');
    }

    public function search(Request $request)
    {
        $id = Session::get('user.id');

        if (Session::get('user.occupation') != 'admin') {

            $user = User::find(Session::get('user.id'));

            $admin = User::find($user->admin_id);

            $id = $admin->id;
        }

        $result = [];
        if (filter_var($request->filter, FILTER_VALIDATE_EMAIL)) {
            $result = Customer::where(
                [
                    ['email', $request->filter],
                    ['user_id', $id]
                ]
            )->get();
        } elseif (is_numeric($request->filter)) {

            $customers = Customer::where('user_id', $id)
                ->select(DB::raw('group_concat(id) as ids'))
                ->first()->toArray();


            $phones = Phone::where(
                'number',
                'like',
                "%$request->filter%"
            )->whereIn(
                'customer_id',
                explode(',', $customers["ids"])
            )->get()->toArray();

            $result = array_map(function ($value) {
                return Customer::find($value["customer_id"]);
            }, $phones);
        } else {
            $result = Customer::where(
                [
                    ['name', 'like', "%$request->filter%"],
                    ['user_id', $id]
                ]
            )->get();
        }

        return view('customer.index', ['customers' => $result]);
    }
}
