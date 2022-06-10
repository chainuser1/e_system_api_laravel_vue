<?php

namespace App\Http\Controllers;

use App\Personnel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PersonnelResource;
use App\Http\Resources\PersonnelCollection;
class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personnels = Personnel::all();
        if($personnels->isEmpty()){
            return response()->json([
                'message' => 'No personnel found'
            ], Response::HTTP_NO_CONTENT);
        }
        else{
            return response()->json(
                new PersonnelCollection($personnels)
            , Response::HTTP_OK);
        }
    }


    protected function validateRequest()
    {
        return request()->validate([
           'employee_number' => 'required|unique:personnels',
           'first_name' => 'required|alpha_dash|max:30',
           'last_name' => 'required|alpha_dash|max:30',
           'middle_name' => 'alpha_dash|max:30',
           'suffix' => 'alpha_num|max:30',
           'type' => 'alpha_dash|max:30',
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
        //
        $personnel = Personnel::create($this->validateRequest());
        return response()->json(
            new PersonnelResource($personnel),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function show(Personnel $personnel)
    {
        // if found return personnel else return not found
        if($personnel){
            return response()->json(
                new PersonnelResource($personnel),Response::HTTP_OK);
        }
        else{
            return response()->json([
                'message' => 'Personnel not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personnel $personnel)
    {
        //
        $personnel->update($this->validateRequest());
        return response()->json(
            new PersonnelResource($personnel),Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personnel $personnel)
    {
        //
        $personnel->delete();
    }
}
