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
        //    get data request from form-data and put it in an array
            

            // upload file
            if($request->hasFile('file_url')){
                $file = $request->file('file_url');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('/uploads'), $fileName);
                $file_url = '/uploads/' . $fileName;
            } else {
                $file_url = null;
            }
            $file_url = $request->file_url;
            $validator = Validator::make($request->all(),[
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'subject_id' => 'required|integer',
                'instructor_id' => 'required|integer',
                'file_url' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }
            $activity = Activity::find($request->id);
            if ($activity) {
                // update activity
                $activity->updateOrCreate([
                    'title' => $request->title,
                    'description' => $request->description,
                    'subject_id' => $request->subject_id,
                    'instructor_id' => $request->instructor_id,
                    'file_url' => $request->file_url,
                ]);
                return response()->json(
                    new ActivityResource($activity),
                    Response::HTTP_OK
                );

            } else {
                return response()->json(['message' => 'Activity not found'], 404);
            }


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
    public function destroy(Request $request, Activity $activity)
    {
        
        // delete the file if it exists
        if($activity->file_url){
            unlink($activity->file_url);
        }
        // delete the activity
        $activity->delete();
        return response()->json(['message'=>'Activity deleted successfully'], 200);

    }
}
