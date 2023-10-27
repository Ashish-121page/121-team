<?php 
/**
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            
            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 0])) {
                // return response()->json([
                //     'error' => 'This account is not activated.'
                // ], 401);
                // $this->guard()->logout();
                // $request->session()->invalidate();
                // $request->session()->regenerateToken();

                   // return redirect()->intended('dashboard');
                   $this->guard()->logout();
                   $this->incrementLoginAttempts($request);
                   // return response()->json([
                   //     'error' => 'This account is not activated.'
                   // ], 401);
                   return redirect()->back()->with('error', 'This account is not activated. ');

            } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
                if(AuthRole() == 'User'){
                    // return redirect('/customer/dashboard');
                    return redirect('/panel/dashboard');

                }else{
                    return redirect('/panel/dashboard');
                }
            } elseif(Auth::attempt([ 'phone' => $request->email, 'password' => $request->password,'status' => 1 ])){
                 if(AuthRole() == 'User'){
                    // return redirect('/customer/dashboard');
                    return redirect('/panel/dashboard');

                }else{
                    return redirect('/panel/dashboard');
                }
            }elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 2])) {
                 if(AuthRole() == 'User'){
                    // return redirect('/customer/dashboard');
                    return redirect('/panel/dashboard');
                }else{
                    return redirect('/panel/dashboard');
                }
            }
        } else {
           
            $this->incrementLoginAttempts($request);
            return redirect()->back()->with('error','Credentials do not match our database.')->withInput($request->all());
            // return response()->json([
            //     'error' => 'Credentials do not match our database.'
            // ], 401);
        }
        
            
    }

    protected function validateLogin(Request $request)
    {
        if(getSetting('recaptcha') == 0){
            $validate = 'recaptcha|sometimes';
        }else{
            $validate = 'recaptcha|required';
        }
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => $validate,
        ]);
    }
    // custom logout function
    // redirect to login page
    public function logout(Request $request)
    {
        //Make Log
        makeLog($activity = "Logout", $ip = $request->ip());
        if (authRole() == 'Admin') {
            $redirect = '/auth/login';
        } else {
            $redirect = '/';
        }
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect($redirect);
    }

    
    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password')];
        }
        return ['email' => $request->get('email'), 'password'=>$request->get('password')];
    }
}
