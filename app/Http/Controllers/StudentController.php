<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Exception;

class StudentController extends Controller
{
   
    public function index()
    {
        try {
            $students = Student::with('user:id,name,email')->get();

            return StudentResource::collection($students);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch students', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
        ]);

      
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
           
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('student');

          
            $student = Student::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
            ]);

            return response()->json(['message' => 'Student created successfully', 'student' => $student], 201);
        } catch (Exception $e) {
         
            return response()->json(['error' => 'An error occurred while creating the student.', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Student $student)
{
    try {
        return new StudentResource($student->load('user:id,name,email')); 
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch student', 'message' => $e->getMessage()], 500);
    }
}

public function update(Request $request, Student $student)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => [
            'nullable',
            'email',
            'max:255',
            Rule::unique('users')->ignore($student->user_id),
        ],
        'phone' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        $student->user->update($request->only(['name', 'email']));
        $student->update($request->only(['phone']));

        return response()->json(['message' => 'Student updated successfully', 'student' => $student], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while updating the student.', 'message' => $e->getMessage()], 500);
    }
}


    public function destroy(Student $student)
    {
        try {
            $student->user->delete();
            $student->delete();

            return response()->json(['message' => 'Student deleted successfully'], 204);
        } catch (Exception $e) {
           
            return response()->json(['error' => 'An error occurred while deleting the student.', 'message' => $e->getMessage()], 500);
        }
    }
}
