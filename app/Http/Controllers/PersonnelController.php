<?php

namespace App\Http\Controllers;

use App\Personnel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PersonnelResource;
use App\Http\Resources\PersonnelCollection;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Validator;
use App\User;
class PersonnelController extends Controller
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
        // if user can view any personnel
        if ($request->user()->can('viewAny', Personnel::class)) {
            //return all personnels
            $personnels = Personnel::all();
            // check if personnels is empty
            if($personnels->isEmpty()){
                return response()->json([
                    'message' => 'No personnels found'
                ], Response::HTTP_NOT_FOUND);
            }
            else{
                return response()->json(
                new PersonnelCollection($personnels)
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
        // check if user is authorized to create a personnel
        if ($request->user()->can('create', Personnel::class)) {
            // create a random personnel number with
        $randomPersonnelNumber = $this->generatePersonnelNumber();
        // check if personnel number already exists


        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
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

        // create a new personnel
        $personnel = Personnel::create([
            'employee_number' => $randomPersonnelNumber,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'suffix' => $request->suffix,
            'type' => $request->type,
        ]);

        // return a new personnel resource
        return response()->json(
            [
                'message' => 'Personnel created successfully',
                'personnel' => new PersonnelResource($personnel)
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
     * @param  \App\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function show(Personnel $personnel)
    {
        //
        return response()->json(
            new PersonnelResource($personnel),Response::HTTP_OK);
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
        //update only if the user is authorized to update a personnel
        if ($request->user()->can('update', $personnel)) {
            // check if personnel number already exists
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:255',
                'type' => 'required|string|max:255',
            ]);

            // if errors are found return in an array of errors
            if($validator->fails()){
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // update the personnel
            // check if update is already done
            if($personnel->update($request->all())){

              $user = User::where('membership_number','employee_number')->first();

              if($user)
                  $user->update([
                    'name'=> $request->first_name.' '.$request->middle_name.' '.$request->last_name.' '+$request->suffix,
                  ]);


                return response()->json([
                    'message' => 'Personnel updated successfully'
                ], Response::HTTP_OK);
            }
            else{
                return response()->json([
                    'message' => 'Personnel update failed'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Personnel $personnel)
    {
        // delete only if the user is authorized to delete a personnel
        if ($request->user()->can('delete', $personnel)) {
           $emp=$personnel;
           $personnel->delete();
           $user = User::where('membership_number',$emp->empoyee_number)->first();
              if($user)
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

    protected function generatePersonnelNumber(){
        // create a random personnel number with 4 random letters prefix and 8 random digits that is unique
       //use string random to generate a random string
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $randomPersonnelNumber = substr(str_shuffle($letters), 0, 4).'-'.substr(str_shuffle($numbers), 0, 12);


        // check if personnel number already exists
        $personnel = Personnel::where('personnel_number', $randomPersonnelNumber)->first();
        if($personnel){
            $this->generatePersonnelNumber();
        }
        else{
            return $randomPersonnelNumber;
        }
    }
}
