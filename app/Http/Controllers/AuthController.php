<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('post')) {
            $this->validate($request, [
                'email'=>'required|email',
                'password'=>'required'
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if(!$user || !Hash::check($request->input('password'), $user->password)) {
                return redirect('/login')->withErrors([
                    'login' => 'Email or password incorrect!'
                ])->withInput();
            }

            Auth::login($user);

            return redirect('/dashboard');
        }

        return view('auth/login');
    }

    public function register(Request $request)
    {
        // TODO
        if($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'email'=>'required|email',
                'password'=>'required'
            ]);

            $user = User::where('name', $request->input('name'))->first();

            $user = User::where('email', $request->input('email'))->first();

            if(!$user || !Hash::check($request->input('password'), $user->password)) {
                return redirect('/register')->withErrors([
                    'register' => 'Something incorrect!'
                ])->withInput();
            }

        // return redirect('/dashboard');

            // validate request
            // create user
            // login user or activate email
            // redirect to dashboard or login
        }

        return view('auth/register');
    }
}
