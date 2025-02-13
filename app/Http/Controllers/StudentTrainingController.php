<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentTraining;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class StudentTrainingController extends Controller
{
  
    public function optIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'required|exists:training_schedules,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
       
            $student = Student::where('user_id', Auth::id())->first();
            

           

            $studentTraining = StudentTraining::create([
                'student_id' => $student->id,
                'schedule_id' => $request->schedule_id,
                'status' => 'opted-in',
            ]);

            return response()->json(['message' => 'Successfully opted in', 'data' => $studentTraining], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to opt-in. Please try again later.', 'details' => $e->getMessage()], 500);
        }
    }

    
    public function optOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'required|exists:training_schedules,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
          
            $student = Student::where('user_id', Auth::id())->first();
            if (!$student) {
                return response()->json(['error' => 'Only students can opt out.'], 403);
            }

            $deleted = StudentTraining::where('student_id', $student->id)
                ->where('schedule_id', $request->schedule_id)
                ->delete();

            if ($deleted) {
                return response()->json(['message' => 'Successfully opted out'], 200);
            } else {
                return response()->json(['message' => 'No record found to opt-out.'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to opt-out. Please try again later.', 'details' => $e->getMessage()], 500);
        }
    }
}
