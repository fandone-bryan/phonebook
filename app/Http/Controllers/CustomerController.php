<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Customer;
use App\Phone;
use Session;
use DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::where('user_id', Session::get('user.id'))->get();

        return view('customer.index', ['customers' => $customer]);
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
        $result = [];
        if (filter_var($request->filter, FILTER_VALIDATE_EMAIL)) {
            $result = Customer::where(
                [
                    ['email', $request->filter],
                    ['user_id', Session::get('user.id')]
                ]
            )->get();
        } elseif (is_numeric($request->filter)) {

            $customers = Customer::where('user_id', Session::get('user.id'))
            ->select(DB::raw('group_concat(id) as ids'))
            ->first()->toArray();

            
            $phones = Phone::where(
                'number', 'like', "%$request->filter%"
            )->whereIn(
                'customer_id', explode(',', $customers["ids"]))->get()->toArray();

            $result = array_map(function ($value) {
                return Customer::find($value["customer_id"]);
            }, $phones);
        } else {
            $result = Customer::where(
                [
                    ['name', 'like', "%$request->filter%"],
                    ['user_id', Session::get('user.id')]
                ]
            )->get();
        }

        return view('customer.index', ['customers' => $result]);
    }
}
