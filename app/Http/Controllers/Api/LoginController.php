<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    public function index()
    {
        $get_user=user::all();
        return response()->json($get_user);
    }

    // This function handles the login request
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required_without:phone_number', 'email'],
            'phone_number' => ['required_without:email', 'string'],
            'password' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $data = $validator->validated();

        // dd($request->only('phone_number','password'));

        if (isset($data['email']) && isset($data['phone_number'])) {
            return response()->json(['errors' => ['Only one login method is required with email or phone number!']], 400);
        }

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $user->last_seen = now();
            $user->save();

            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User login successful.',
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

    }

    
    public function logout(Request $request) {

        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully.',
        ], 200);

    }
    // private function login_via_email($data){
    //     Auth::attempt($data);
    // }
    // private function login_via_phone_number($data){
    //     Auth::attempt($data);
    //     // Auth::attempt($request->only('phone_number','password'));
    // }

    // private


       
    
}

// public function login(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'email_or_phone' => 'required',
//         'password' => 'required|min:8',
//     ]);

//     // Check if validation fails
//     if ($validator->fails()) {
//         return response()->json([
//             'success' => false,
//             'message' => $validator->errors()->first(),
//         ], 422);
//     }

//     // Determine if the input is an email or phone number
//     $loginField = filter_var($request->input('email_or_phone'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

//     // Define the credentials array
//     $credentials = [
//         $loginField => $request->input('email_or_phone'),
//         'password' => $request->input('password'),
//     ];

//     // Attempt to log in the user
//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();
//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'success' => true,
//             'message' => 'User login successful.',
//             'token' => $token,
//             'user' => $user,
//         ]);
//     } else {
//         return response()->json([
//             'success' => false,
//             'message' => 'Invalid credentials.',
//         ], 401);
//     }
// }

// {
//     $loginField = filter_var($request->input('login_field'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

//     // $rules = [
//         // $loginField => 'required',

//     // ];

//     if ($loginField == 'email') {
//         $rules['email'] = 'required|email';
//         unset($rules['phone_number']);
//     }
//     elseif ($loginField == 'phone_number') {
//         $rules['phone_number'] = 'required|numeric|min:11|unique:users,phone_number';
//         unset($rules['email']);

//     }
//     else {
//         return response()->json([
//             'success' => false,
//             'message' => 'Invalid login field.',
//         ], 422);
//     }

//     $validator = Validator::make($request->all(), [
//         'email'=>'required|integer|str|unique',
//         'password' => 'required|min:8',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'success' => false,
//             'message' => $validator->errors()->first(),
//         ], 422);
//     }

//     if (!in_array($loginField, ['email', 'phone_number'])) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Invalid login field.',
//         ], 422);
//     }

//     $credentials = [
//         $loginField => $request->input($loginField),
//         'password' => $request->password,
//     ];

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();
//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'success' => true,
//             'message' => 'User login successful.',
//             'token' => $token,
//             'user' => $user,
//         ]);
//     }

//     return response()->json([
//         'success' => false,
//         'message' => 'Invalid credentials.',
//     ], 401);
// }
