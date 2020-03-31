<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Customer;
use App\Phone;
use Session;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::where('user_id', Session::get('user.id'))->get();

        return view('customer.index', ['customers' => $customer]);
    }

    public function create()
    {
        return view('customer.form');
    }

    public function store(Request $request)
    {
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
            $phones = Customer::find(Session::get('user.id'))
                ->phones
                ->where('number', 'like', $request->filter)
                ->toArray();

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
