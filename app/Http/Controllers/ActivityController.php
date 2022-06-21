<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
// use Resource
use App\Http\Resources\ActivityResource;
// use Validator
use Illuminate\Support\Facades\Validator;
class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::all();
        if ($activities->count() > 0) {
            return response()->json(ActivityResource::collection($activities), 200);
        } else {
            return response()->json(['message' => 'No activities found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        // return a rewource
        return response()->json(
            new ActivityResource($activity),
            Response::HTTP_OK
        );
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->user()->can('create', Activity::class)){
            $validator = Validator::make($request->all(),
                [
                'title' => 'required|string|max:75',
                'description' => 'required|string|max:512',
                // 0file url must be a valid file of zip, pdf, docx, doc, png, jpg, jpeg, gif
                //excel files are allowed but videos are not
                // 'file_url' => 'nullable|string|file|mimes:zip,pdf,docx,png,jpg,jpeg,gif,pptx,xlsx|max:5120',
                'instructor_id' => 'required|integer|exists:users,id',
                'subject_id' => 'required|integer|exists:subjects,id',
            ]
            );

            if ($validator->fails()) {
                return response()->json(['message'=>'Check your input, something went wrong',
                'errors'=>$validator->errors()], 400);
            }

            $activity = Activity::updateOrCreate([
                    'id' => $request->id,
                    'title' => $request->title,
                   ],[

                'description' => $request->description,
                'instructor_id' => $request->user()->id,
                'subject_id' => $request->subject_id,

            ]);
            if($activity)
                return response()->json(
                    new ActivityResource($activity), 201
                );
            else
              return response()->json(
                  ['message'=>'An error occurred'], 201
              );


        }else{
            return response()->json(['message'=>'You are not authorized to create or update an activity'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Activity $activity)
    {
        if($request->user()->can('delete', $activity)){
            // delete the file if it exists
            if($activity->file_url){
                unlink($activity->file_url);
            }
            // delete the activity
            $activity->delete();
            return response()->json(['message'=>'Activity deleted successfully'], 200);
        }
        else{
            return response()->json(['message'=>'You are not authorized to delete this activity'], 401);
        }
    }
}
