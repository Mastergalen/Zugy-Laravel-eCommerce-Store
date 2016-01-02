<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthenticateUser;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function redirectPath()
    {
        return localize_url('routes.shop.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin(Request $request) {
        return view('auth.login');
    }

    public function facebookLogin(AuthenticateUser $authenticateUser, Request $request) {
        return $authenticateUser->facebookLogin($request);
    }

    public function googleLogin(AuthenticateUser $authenticateUser, Request $request) {
        return $authenticateUser->googleLogin($request);
    }

    public function getLogout() {
        auth()->logout();
        return redirect('/');
    }

    /**
     * Called after user has logged in successfully
     */
    public function authenticated()
    {
        return redirect()->intended($this->redirectPath())->with(['success' => 'Logged in.']);
    }
}
