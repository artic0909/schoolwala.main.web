<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\application\AppController as AppController;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends AppController
{
    /**
     * Register a new student.
     */
    public function register(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'mobile' => 'required|string|max:15',
            'age' => 'required|string|max:3',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ----- AUTO GENERATE STUDENT ID -----
        $year   = date('y'); // last 2 digits of year
        $prefix = "SW";

        // Get class name
        $class = \App\Models\Classes::findOrFail($request->class_id);
        $className = strtoupper(str_replace(' ', '', $class->name));

        // Find last student for this class
        $lastStudent = Student::where('class_id', $request->class_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastStudent && preg_match('/-(\d+)$/', $lastStudent->student_id, $matches)) {
            $lastNumber = (int) $matches[1];
        } else {
            $lastNumber = 0;
        }

        // Increment & pad number
        $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        $studentId = "{$year}-{$prefix}-{$className}-{$nextNumber}";

        $student = Student::create([
            'class_id' => $request->class_id,
            'student_id' => $studentId, // Use generated ID
            'student_name' => $request->student_name,
            'parent_name' => $request->parent_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'age' => $request->age,
            'password' => Hash::make($request->password),
        ]);

        // Send Registration Email
        try {
            \Illuminate\Support\Facades\Mail::to($student->email)->send(new \App\Mail\Registration($student));
        } catch (\Exception $e) {
            // Log error or ignore if mail fails, but don't stop registration flow
        }

        $token = $student->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'student' => $student,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Student registered successfully.');
    }

    /**
     * Login student and create token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return $this->sendError('Unauthorized', ['error' => 'Invalid credentials'], 401);
        }

        $token = $student->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'student' => $student,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Student logged in successfully.');
    }

    /**
     * Logout user (revoke the token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'User logged out successfully.');
    }

    /**
     * Get the authenticated user.
     */
    public function user(Request $request)
    {
        return $this->sendResponse($request->user(), 'User retrieved successfully.');
    }
}
