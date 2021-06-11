<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    // for google
     public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

       $this->_registerOrLoginUser($user);
       return redirect()->route('dashboard');
    }
    // for github
     public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();

       $this->_registerOrLoginUser($user);
       return redirect()->route('dashboard');
    }
    // for facebook
     public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

       $this->_registerOrLoginUser($user);
       return redirect()->route('dashboard');
    }
    protected function _registerOrLoginUser($info)
    {
        $user = User::where('email','=',$info->email)->first();
        if(!$user){
            $user->name = $info->name;
            $user->email = $info->email;
            $user->provider_id = $info->id;
            $user->avatar = $info->avatar;
            $user->save();
        }
        Auth::login($user);
    }
}
