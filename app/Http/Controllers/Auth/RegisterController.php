<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
// use Personeel and Student models
use App\Personnel;
use App\Student;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'username' => ['string', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => empty($data['username']) ? $data['email'] : $data['username'],
        ]);
    }

    protected function verifySrn(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'membership_number' => ['required', 'string'],
        ]);

        // if the request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid employee number or membership number',
                'errors' => $validator->errors()
            ], 400);
        }

        // check if the employee number exists
        $personnel = Personnel::where('employee_number', $request->membership_number)->first();
        $student = Student::where('student_number', $request->membership_number)->first();

        // if neither exists
        if (!$personnel && !$student) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid employee number or student number',
            ], 400);
        }
        
        // if either exists
        if ($personnel) {
            return response()->json([
                'success' => true,
                'message' => 'Employee number is valid',
                'type' => 'personnel',
                'data' => $personnel
            ], 200);
        }

        if ($student) {
            return response()->json([
                'success' => true,
                'message' => 'Student number is valid',
                'type' => 'student',
                'data' => $student
            ], 200);
        }
    }
}
