<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::all();

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

        $customer->save();
        
        return redirect('/');
    }
}
