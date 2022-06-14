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
        $validator = Validator::make($request->all('email', 'password'), [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        };

        if(Auth::guard('web')->attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::guard('web')->user();
            $success['token'] = $user->createToken(env('PASSPORT_CLIENT_SECRET'))-> accessToken;
            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Can not log in with the data provide.'], 401);
        }        
    }
   
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        // redirect to login page
        return redirect('/');
    }
}
