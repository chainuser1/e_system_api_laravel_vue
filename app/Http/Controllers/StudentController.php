<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{

    
    /**
     * 
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // if user can view any student
        if ($request->user()->can('viewAny', Student::class)) {
            //return all students
            $students = Student::all();
            // check if students is empty 
            if($students->isEmpty()){
                return response()->json([
                    'message' => 'No students found'
                ], Response::HTTP_NOT_FOUND);
            }
            else{
                return response()->json(
                new StudentCollection($students)
                , Response::HTTP_OK);
            }
        }
        else{
            // return a not authorized response
            return response()->json([
                'message' => 'You are not authorized to view this resource'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if user is authorized to create a student
        if ($request->user()->can('create', Student::class)) {
            // create a random student number with 
        $randomStudentNumber = $this->generateStudentNumber();
        // check if student number already exists
        

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // if errors are found return in an array of errors
        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // create a new student
        $student = Student::create([
            'student_number' => $randomStudentNumber,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'suffix' => $request->suffix,
            'status' => 'active',
            
        ]);

        // return a new student resource
        return response()->json(
            new StudentResource($student), Response::HTTP_CREATED);
        }
        else{
            // return a not authorized response
            return response()->json([
                'message' => 'You are not authorized to create this resource'
            ], Response::HTTP_UNAUTHORIZED);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
        return response()->json(
            new StudentResource($student),Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
        $student->update($request->all());
        return response()->json(
            new StudentResource($student),Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        // using soft delete
        $student->delete();
        return response()->json([
            'message' => 'Student deleted'
        ], Response::HTTP_OK);
        
    }

    protected function generateStudentNumber(){
        $faker = Faker::create();
        $studentNumber = '';
        // unique student number
        do{
            $studentNumber = $faker->toUpper($faker->unique()->randomLetter). $faker->unique()->randomNumber(4) 
                        . $faker->unique()->randomNumber(4);
        }while(Student::where('student_number', $studentNumber)->exists());
        return $studentNumber;
    }
}
