<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthUserController extends Controller
{
    
    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$loginUserData['email'])->where('status', 1)->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'message' => 'Logged in successfully',
            'user' => $user
        ]);
    }

    public function register(Request $request) 
    {
        $validatedData = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:255'],
            'organization_email' => ['required', 'string', 'email', 'max:255'],
            'organization_region' => ['required', 'string', 'max:255'],
            'organization_city' => ['required', 'string', 'max:255'],
            'manager_name' => ['required', 'string', 'max:255'],
            'manager_mobile' => ['required', 'string', 'max:255'],
            'manager_email' => ['required', 'string', 'email', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_mobile' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Ensure email is unique in 'users' table
            'contact_job_title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'password'=>'required|min:8',
        ]);
        $user = User::create([
           'organization_name' => $validatedData['organization_name'],
            'license_number' => $validatedData['license_number'],
            'organization_email' => $validatedData['organization_email'],
            'organization_region' => $validatedData['organization_region'],
            'organization_city' => $validatedData['organization_city'],
            'manager_name' => $validatedData['manager_name'],
            'manager_mobile' => $validatedData['manager_mobile'],
            'manager_email' => $validatedData['manager_email'],
            'contact_name' => $validatedData['contact_name'],
            'contact_mobile' => $validatedData['contact_mobile'],
            'email' => $validatedData['email'],
            'contact_job_title' => $validatedData['contact_job_title'],
            'name' => $validatedData['name'],
            'password' => Hash::make($validatedData['password']),
        ]);
       
        if($user){
            return response()->json(['message' => 'User Created Successfully', 201]);
        }else{
            return response()->json(['message' => 'Failed to register', 500]);
        }
    }

    public function logout(Request $request)
    {
        $user = auth()->user()->tokens()->delete();
        if($user){
            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to logout'
            ]);
        }
        
    }

    public function user(Request $request)
    {
        $user = auth()->user();
        if($user){
            return response()->json([
                'message' => 'User fetched successfully',
                'user' => $user
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to fetch user'
            ]);
        }
    }


}