<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
// use UserResource;
use App\Http\Resources\UserResource;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInstructors(Request $request)
    {
        //if user is admin or teacher
        if($request->user()->role == 'admin' || $request->user()->role == 'instructor'){
            //get all users
            $users = User::where('role','instructor')->get();
            // if users not empty
            if(!$users->isEmpty()){
                // return a collection of users as a resource
                return response()->json(UserResource::collection($users), 200);
            }else {
                // return error message
                return response()->json(['message' => 'No instructors found who have accounts'], 404);
            }
        }else {
            // return error message
            return response()->json(['message' => 'You are not authorized to view this data'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
