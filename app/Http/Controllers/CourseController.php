<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
  

    public function index()
    {
        try {
            $courses = Course::all();
            return response()->json(['courses' => $courses], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch courses', 'error' => $e->getMessage()], 500);
        }
    }

  
    public function store(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1',  
        ]);

      
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422); 
        }

    
        try {
            $course = Course::create($request->all());
            return response()->json(['message' => 'Course created successfully', 'course' => $course], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create course', 'error' => $e->getMessage()], 500);
        }
    }

   
    public function show(Course $course)
    {
        try {
            return response()->json(['course' => $course], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch course details', 'error' => $e->getMessage()], 500);
        }
    }

 
    public function update(Request $request, Course $course)
    {
     
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',  
        ]);

    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);  
        }

        try {
            $course->update($request->all());
            return response()->json(['message' => 'Course updated successfully', 'course' => $course], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update course', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Course $course)
    {
        try {
           
            if (!$course) {
                return response()->json(['message' => 'Course not found'], 404);
            }
    
          
            $course->delete();
    
           
            return response()->json([
                'message' => 'Course deleted successfully',
                'course'  => $course
            ], 200);
        } catch (\Exception $e) {
          
            return response()->json([
                'message' => 'Failed to delete course',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
