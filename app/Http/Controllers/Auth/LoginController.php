<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
        $request->validate([
            'username' => 'required|string|max:25',
            'password' => 'required|string|min:8|max:25',
        ]);
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => "2",
            'client_secret' => "xTne4UjtX2OqJ5zU4HJcL6ZMlxnGGyML18gAE2dX",
            'username' => $request->username,
            'password' => $request->password
        ]);

        $requestToken = Request::create(env('APP_URL').'/oauth/token', 'POST');
        $response = Route::dispatch($requestToken);
        return $response;
    }

    public function getToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => "2",
            'client_secret' => "xTne4UjtX2OqJ5zU4HJcL6ZMlxnGGyML18gAE2dX",
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
   
}
