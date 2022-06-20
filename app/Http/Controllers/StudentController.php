<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Validator;
use App\User;
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
                StudentResource::collection($students)
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
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
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
            'status' => $request->status,

        ]);

        // return a new student resource
        return response()->json(
            [
                'message' => 'Student created successfully',
                'student' => new StudentResource($student)
            ], Response::HTTP_CREATED);
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
        //update only if the user is authorized to update a student
        if ($request->user()->can('update', $student)) {
            // check if student number already exists
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'required|string|max:255',
                'suffix' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
            ]);

            // if errors are found return in an array of errors
            if($validator->fails()){
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // update the student
            // check if update is already done
            if($student->update($request->all())){

               $user = User::where('membership_number', $student->student_number)->first();

               if($user)
                   $user->update([
                     'name'=> $request->first_name.' '.$request->middle_name.' '.$request->last_name.' '.$request->suffix,
                   ]);

                return response()->json([
                    'message' => 'Student updated successfully'
                ], Response::HTTP_OK);
            }
            else{
                return response()->json([
                    'message' => 'Student update failed'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Student $student)
    {
        // delete only if the user is authorized to delete a student
        if ($request->user()->can('delete', $student)) {
            // check if student number already exists
           $stu=$student;
           $student->delete();
           $user = User::where('membership_number',$stu->student_number)->first();
              if($user)
                // force delete user
                $user->forceDelete();
            return response()->json([
                'message' => 'Student deleted successfully'
            ], Response::HTTP_OK);
        }
        else{
            return response()->json([
                'message' => 'You are not authorized to delete this resource'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    protected function generateStudentNumber(){
        // create a random student number with 4 random letters prefix and 8 random digits that is unique
       //use string random to generate a random string
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $randomStudentNumber = substr(str_shuffle($letters), 0, 4).'-'.substr(str_shuffle($numbers), 0, 8);


        // check if student number already exists
        $student = Student::where('student_number', $randomStudentNumber)->first();
        if($student){
            $this->generateStudentNumber();
        }
        else{
            return $randomStudentNumber;
        }
    }
}
