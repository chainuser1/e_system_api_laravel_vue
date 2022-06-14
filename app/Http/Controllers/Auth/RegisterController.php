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
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'username' => ['string', 'max:255', 'unique:users'],
    //         // role enum is: student, instructor, staff, admin
    //         'role' => ['required', 'string', 'max:255','in:student,instructor,staff,admin'],
    //         'membership_number' => ['required', 'string', 'max:255', 'unique:users'],   
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $req)
    {
        // create a validator for request
        $validator = Validator::make($req->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'username' => ['string', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:255','in:student,instructor,staff,admin'],
            'membership_number' => ['required', 'string', 'max:255', 'unique:users'], 
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user = User::create([
            "membership_number"=>$req->membership_number,
            "name"=>$req->name,
            "role"=>$req->role,
            "username"=>$req->username,
            "email"=>$req->email,
            "password"=>Hash::make($req->password)
        ]);

        if($user)
            return response()->json([
                "success"=>true,
                "message"=> $req->name.' '.'has been successfully registered.'
            ],201);
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
                'message' => 'Invalid employee number or student number',
                'errors' => $validator->errors()
            ], 400);
        }

        // check if the employee number exists
        
        $personnel =  Personnel::where('employee_number', $request->membership_number)->first();
        $student = Student::where('student_number', $request->membership_number)->first();

        // if both return null, then the employee number does not exist
        if($personnel == null && $student == null) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid employee number or student number',
                'membership_number' => $request->membership_number,
                'errors' => $validator->errors()
            ], 400);
        }
        // if either exists
        elseif ($personnel) {
            return response()->json([
                'success' => true,
                'message' => 'Employee number is exists',
                'type' => $personnel->type,
                'data' => $personnel
            ], 200);
        }

        elseif ($student) {
            return response()->json([
                'success' => true,
                'message' => 'Student number exists',
                'type' => 'student',
                'data' => $student
            ], 200);
        }
    }
}
