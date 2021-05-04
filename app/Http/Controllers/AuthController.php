<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if ( ! $user
                 || ! Hash::check($request->input('password'), $user->password)
            ) {
                return redirect('/login')->withErrors([
                    'login' => 'Email or password incorrect!',
                ])->withInput();
            }

            Auth::login($user);

            return redirect('/dashboard');
        }

        return view('auth/login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name'            => 'required',
                'email'           => 'required|email|unique:users,email',
                'password'        => 'required',
                'passwordRetyped' => 'required|same:password',
            ]);


            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect('login');

            // TODO
            // activate email
        }

        return view('auth/register');
    }
}
