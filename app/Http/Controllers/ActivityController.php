<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
// use Resource
use App\Http\Resources\ActivityResource;
// use Validator
use Illuminate\Support\Facades\Validator;
// use Storage
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;
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
            $file_url = $request->file_url;
            $validator = Validator::make($request->all(),[
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'subject_id' => 'required|integer',
                'instructor_id' => 'required|integer',
                'file_url' => 'file|mimes:docx,pdf,doc,xls,xlsx,ppt,pptx,zip,rar',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()], 400);
            }

            // upload file with uuid
            $file_url = '';
            if ($request->hasFile('file_url')) {
                $uuid = (string)Uuid::generate()->string . '.' . $request->file_url->getClientOriginalExtension();
                //  use move() to move the file to a new location
                $file_url = $request->file_url->move(storage_path('app/activities/files/'), $uuid);
            }
            
            $file_arr_name = explode('/', $file_url);
            $file_url ='/activities/'. end($file_arr_name);
            
            $activity=Activity::updateOrCreate(
                    [
                        'id' => $request->id],  // if id is null, create a new activity 
                    [
                    'title' => $request->title,
                    'description' => $request->description,
                    'subject_id' => $request->subject_id,
                    'instructor_id' => $request->instructor_id,
                    'file_url' => $file_url,
                ]);

            if($activity){
                return response()->json(['message' => 'Activity updated or created successfully',
               'activity' => new ActivityResource($activity)], 200);
            } else {
                return response()->json(['message' => 'Activity not updated or created'], 400);
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
        // if activity has a file_url, delete it
        if($activity->file_url){
        //    delete file from public folder
            $public_path = storage_path('app/activities/files/');
            $file_path = $public_path  . $activity->file_url;
            if(file_exists($file_path)){
                unlink($file_path);
            }
        }
        $activity->delete();
        return response()->json(['message'=>'Activity deleted successfully'], 200);

    }

    // public function downloadFile(Activity $activity)
    // {
    //     // use uuid to download file
    //     $uuid = $activity->file_url;
    //     $file_path = public_path() . '/files/activities/' . $uuid;
    //     if(file_exists($file_path)){
    //         return response()->download($file_path);
    //     } else {
    //         return response()->json(['message'=>'File not found'], 404);
    //     }
    // }
}
