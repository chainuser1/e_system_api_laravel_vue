<?php

namespace App\Http\Controllers;

use App\Enrollment;
use Illuminate\Http\Request;
use App\Http\Resources\EnrollmentResource;
class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // find enrollments by user_id
        $enrollments = Enrollment::where('user_id',$request->user()->id)->get();
        // return collection of enrollments as a resource
        return response()->json([
            'enrollments' => EnrollmentResource::collection($enrollments),
            'message' => 'Enrollments found successfully',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $enrollment = Enrollment::create($request->all());  

        if(!$enrollment) {
            return response()->json(['message' => 'Error has happened to your enrollment'], 500);
        }
        return response()->json([
            'message' => 'Enrollment to subject was successfull',
            'enrollment' => $enrollment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
