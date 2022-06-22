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
           
        
            
            $activity=Activity::updateOrCreate(
                [
                    'id' => $request->id],
                [
                    'title' => $request->title,
                    'description' => $request->description,
                    'subject_id' => $request->subject_id,
                    'instructor_id' => $request->instructor_id,
                    'file_url' => $request->file_url->store('activities'),
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
            $file_url = $activity->file_url;
            $file_path = public_path($file_url);
            if(file_exists($file_path)){
                unlink($file_path);
            }
        }
        $activity->delete();
        return response()->json(['message'=>'Activity deleted successfully'], 200);

    }

    public function downloadFile(Activity $activity)
    {
        // file
        $file_url = $activity->file_url;
        $file_path = storage_path($file_url);
        $headers = array(
        //    file can be a document or a picture
            'Content-Type: application/pdf',
            'Content-Disposition: attachment; filename="' . 
            $file_url . '"',
        );
        return response()->download($file_path, $file_url, $headers);
    }
}
