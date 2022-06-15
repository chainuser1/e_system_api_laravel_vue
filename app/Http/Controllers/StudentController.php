<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = Student::create($request->all());
        return response()->json(
            new StudentResource($student),Response::HTTP_CREATED);
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
}
