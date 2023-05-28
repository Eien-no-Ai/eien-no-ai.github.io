<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use App\Models\Roles;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }*/

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $errorMessage = null;

        // Check if user exists in the database
        $user = User::where('email', $input['email'])->first();
        if (!$user) {
            $errorMessage = 'Invalid email or password.';
            return view('auth.login', compact('errorMessage'));
        }
        
        // Attempt to authenticate the user
        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            if (auth()->user()->is_admin == 1) {
                return redirect()->route('admin');
            } else {
                return redirect()->route('home');
            }
        } else {
            $errorMessage = 'Invalid email or password.';
            return view('auth.login', compact('errorMessage'));
        }
    }

    public function logout(Request $request)
    {

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
        
    }
}
