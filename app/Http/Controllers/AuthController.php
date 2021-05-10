<?php namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            $user = $this->service->loginUser($request);

            if ( ! $user) {
                return redirect(route('login'))
                    ->withErrors(['login' => 'Email or password is incorrect!'])
                    ->withInput();
            }

            return redirect(route('dashboard'));
        }

        if (Auth::check()) {
            return redirect(route('dashboard'));
        }

        return view('auth/login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name'            => 'required',
                'email'           => 'required|email|unique:users,email',
                'password'        => 'required',
                'passwordRetyped' => 'required|same:password',
                'terms'           => 'accepted',
            ]);

            $this->service->registerUser($request);

            return redirect(route('verification.notice'));
        }

        if (Auth::check()) {
            return redirect(route('dashboard'));
        }

        return view('auth/register');
    }

    public function verifyNotice()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect(route('dashboard'));
        }

        return view('auth.verifyEmail');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect(route('dashboard'));
    }

    public function resendVerifyEmail(): RedirectResponse
    {
        $user = Auth::user();

        $user->sendEmailVerificationNotification();

        return back()->with('resent', 'Verification link sent!');
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        }

        if (Auth::check()) {
            return redirect(route('dashboard'));
        }

        return view('auth/forgotPassword');
    }

    public function resetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => 'required|min:8|confirmed',
            ]);

            $status = $this->service->resetPassword($request);

            return $status == Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
        }

        if (Auth::check()) {
            return redirect(route('dashboard'));
        }

        return view('auth/recoverPassword');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
