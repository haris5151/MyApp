<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'user_name' => 'required',
            'phone_number' => 'required|min:11|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',

        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,
                'message' => $validator->errors()->first(),

            ]);

        }

        $user = User::create([

            'user_name' => $request->user_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'address' => $request->address,
            'type' => $request->type,
            'description' => $request->description,
            'is_active'=>$request->is_active,

        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('image/user_img/');
            $imageName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $user->image = $imageName;

            $user->save();
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([

            'success' => true,
            'message' => 'User register successfully',
            'token' => $token,

        ]);

    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'user_name' => 'required',
            'phone_number' => 'required|min:11|numeric',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            // 'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ]);
        }

        $user->update([
            'user_name' => $request->user_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'type' => $request->type,
            'description' => $request->description,
            'is_active'=>$request->is_active
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('image/user_img/');
            $imageName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $user->image = $imageName;
            $user->save();
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'token' => $token,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

}
