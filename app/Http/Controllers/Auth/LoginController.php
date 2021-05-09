<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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

    public function login(Request $request){

        $company_name = $request->company_name;
        $password = $request->password;
 
	   
        $user = Auth::attempt(['company_name' => $company_name, 'password' => $password]);
		
        if($user) {
			
            if(Auth::user()->role_id == 3){  
                if(Customer::where([['user_id','=',Auth::id()],['status','=',1]])->exists()){
					  
                    return redirect()->intended('home');
                } else {
                    return redirect('/logout');
                }
            }
            return redirect()->intended('home');
        } else {
			
            return redirect()->back()->withInput()->with('Error', 'Authentication Failed');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
      }
}
