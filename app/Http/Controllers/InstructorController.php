<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use App\Subject;
use App\Personnel;
// use SubjectResource
use App\Http\Resources\SubjectResource;
class InstructorController extends Controller
{
    public function getMySubjects(Request $request)
    {
        $user = $request->user();
        $subjects = Subject::where('instructor_id', $user->id)->get();
        if(count($subjects) > 0)
        {
            return response()->json([
                'success' => true,
                'data' => SubjectResource::collection($subjects),
                'message' => count($subjects).' Subjects found'
            ], Response::HTTP_OK);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'No subjects found'
            ], Response::HTTP_NOT_FOUND);
        }
    }


}
