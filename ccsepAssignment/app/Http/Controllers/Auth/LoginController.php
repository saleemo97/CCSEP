<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

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

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the form for vulnerable login.
     *
     * @return \Illuminate\View\View
     */
    public function showVulnerableLoginForm()
    {
        return view('auth.vulnerable-login');
    }

    /**
     * Handle the vulnerable login request (with NoSQL Injection vulnerability).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function vulnerableLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Vulnerable NoSQL query allowing NoSQL injection
        $user = User::whereRaw([
            'email' => $email,  // Vulnerable to injection
            'password' => $password
        ])->first();

        // Log the user in
        auth()->login($user);
        redirect('/home')->with('status', 'Welcome ' . $user->name);

    }

    /**
     * Show the secure login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the secure login request (standard safe query).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function secureLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect($this->redirectTo)->with('status', 'Login successful');
        }

        return back()->withErrors('Invalid login credentials.');
    }

    /**
     * Handle logout and redirect to login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect to the login page after logout
    }
}
