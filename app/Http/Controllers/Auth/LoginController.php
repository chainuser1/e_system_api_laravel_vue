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
            'client_id' => 2,
            'client_secret' => "DsOz3QC5G970F5SGjs5A2DsdZQeDrjxUd5XLAPQx",
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
        // remove passport token
        $request->user()->token()->remove();
        // remove laravel token
        return response()->noContent();
        
    }

    public function login(Request $request)
    {
       
        if(Auth::guard('web')->attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::guard('web')->user();
            $success['token'] = $user->createToken(env('PASSPORT_CLIENT_SECRET'))-> accessToken;
            // return response()->json($success, 200);
            return response()->json(['success' => $success,'message'=>'You are now logged in'], 200);
        }
        else{
            // return unable to login
            return response()->json(['errors'=>['The credentials are incorrect'],'success'=>false], 400);
        }        
    }
   
    // public function logout(Request $request)
    // {
    //     Auth::guard('web')->logout();
    //     // redirect to login page
    //     return redirect('/');
    // }
}
