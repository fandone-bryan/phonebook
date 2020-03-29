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

        $user->save();

        $request->session()->forget('form');

        $request->session()->put('user.id', $user->id);
        $request->session()->put('user.name', $user->name);
        $request->session()->put('user.email', $user->email);
        $request->session()->put('user.occupation', $user->occupation);

        return redirect('/');
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
