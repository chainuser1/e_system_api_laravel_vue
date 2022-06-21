<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// load subject resource
use App\Http\Resources\SubjectResource;
// use Validator
use Illuminate\Support\Facades\Validator;
class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subjects = Subject::all();
        // if subjects not empty
        if(!$subjects->isEmpty()){
            // return a collection of subjects as a resource
            return response()->json(SubjectResource::collection($subjects), 200);
        }else {
            // return error message
            return response()->json(['message' => 'No subjects found, start adding'], 404);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //if subject id is not equal to 0

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'instructor_id' => 'nullable|integer|exists:users,id',
        ]);

        if($validation->fails()){
            return response()->json(['message' => 'Validation failed', 'errors' => $validation->errors()], 400);
        }



        $subject = Subject::find($request->id);
        if($subject){
            // update subject
            $subject->update([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'user_id' => $request->user()->id,
                'instructor_id' => $request->instructor_id,
            ]);
            // return a response as a resource
            return response()->json([
                'message' => 'Subject updated successfully'
            ], Response::HTTP_OK);
        }else{
            // create a new subject
            $subject = Subject::create([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'user_id' => $request->user()->id,
                'instructor_id' => $request->instructor_id,
            ]);
            // return a response as a resource
            return response()->json([
                'message' => 'Subject created successfully',
                'subject' => new SubjectResource($subject)
            ], Response::HTTP_CREATED);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
