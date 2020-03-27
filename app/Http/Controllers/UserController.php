<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'name.required' => 'Preencha seu nome.',
            'email.required' => 'Preencha seu e-mail',
            'email.email' => 'E-mail inválido',
            'password.required' => 'Preencha sua senha'
        ]);

        if ($validator->fails()) {
            $request->session()->put('form', 'signup');
            return back()->withErrors($validator);
        }
        
        $userExists = (User::where('email', $request->email)->get())->toArray();

        if ($userExists) {
            $request->session()->put('form', 'signup');

            return back()->withErrors(['user_exists' => 'E-mail já cadastrado']);
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->occupation = $request->occupation;

        $user->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}