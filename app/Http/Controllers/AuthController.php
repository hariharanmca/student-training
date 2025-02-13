<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Spatie\Permission\Models\Role;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller {
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:admin,student',
                'phone' => 'nullable|string', 
            ]);
    
           
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $user->assignRole($request->role);
    
            if ($request->role == 'student') {
                $student = Student::create([
                    'user_id' => $user->id,
                    'phone' => $request->phone, 
                ]);
            }
    
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while registering the user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
          
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);
    
           
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }
    
          
            $user = User::where('email', $request->email)->first();
    
           
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials. Please check your email and password and try again.'], 401);
            }
    
           
            $token = $user->createToken('authToken')->plainTextToken;
    
           
            return response()->json([
                'message' => 'Login successful!',
                'user' => $user,
                'token' => $token
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
