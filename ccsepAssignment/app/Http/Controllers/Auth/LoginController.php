<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Also make sure Log is imported


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
        DB::enableQueryLog(); // Enable query logging
    
        $email = $request->input('email');
    
        // Log the email input for debugging
        Log::info("Vulnerable login attempt with email: " . $email);
    
        // Decode the input to allow NoSQL injection (turns JSON string into an array)
        $emailQuery = json_decode($email, true);
    
        // Vulnerable NoSQL query allowing NoSQL injection
        $user = User::whereRaw([
            'email' => $emailQuery  // Now using decoded JSON to inject properly
        ])->first();
    
        // Log the executed MongoDB query
        Log::info('Executed query:', DB::getQueryLog());
    
        if ($user) {
            Log::info("User found: " . $user->name);
    
            // Log the user in
            auth()->login($user);
    
            if (auth()->check()) {
                Log::info("Login successful for user: " . $user->name);
                return redirect('/home')->with('status', 'Welcome ' . $user->name);
            } else {
                Log::error("Login failed after user retrieval.");
                return back()->withErrors('Failed to log in.');
            }
        } else {
            Log::error("No user found with the provided email.");
            return back()->withErrors('Invalid login credentials.');
        }
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
