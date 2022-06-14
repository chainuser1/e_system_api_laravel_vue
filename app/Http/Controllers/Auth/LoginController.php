<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
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

    public function store(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 4,
            'client_secret' => "CaHWzQmN8kGNUuxHdM3VYvJx7GyWARghkBHYYpVz",
            'username' => $request->username,
            // include password
            'password'=>$request->password,
        ]);

        $requestToken = Request::create(env('APP_URL').'/oauth/token', 'POST');
        $response = Route::dispatch($requestToken);
        return $response;
    }

    public function getToken(Request $request)
    {
        $request->request->add([
            'grant_type'=>'password',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'username' => $request->username,
            'password' => $request->password
        ]);

        $requestToken = Request::create(env('APP_URL').'/oauth/token', 'POST');
        $response = Route::dispatch($requestToken);
        return $response;
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->noContent();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all('username', 'password'), [
        'username' => 'required|string|max:255',
        'password' => 'required|string|min:7|max:25',
        ]);
  

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if(Auth::guard('web')->attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::guard('web')->user();
            $success['token'] = $user->createToken(env('PASSPORT_CLIENT_SECRET'))-> accessToken;
            // return back with errors using redirect() back()
            return redirect()->route('home')->with('success', 'You are logged in');
        }
        else{
            // 
            return redirect()->back()
                ->withErrors(['These credentials do not match our records.'])
                ->withInput();
        }        
    }
   
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        // redirect to login page
        return redirect('/');
    }
}
