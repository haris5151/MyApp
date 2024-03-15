<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class RegisterController extends Controller

{


    public function register(Request $request) 

    {

        $validator = Validator::make($request->all(),[

            'user_name' => 'required',
            'phone_number' => 'required|min:11|numeric',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',

        ]);

        if($validator->fails()) {

            return response()->json([

                'success' => false,
                'message' => $validator->errors()->first()

            ]);

        }

        $user = User::create([

            'user_name'     => $request->user_name,
            'phone_number'=>$request->phone_number,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'gender'=>$request->gender,
            'country'=>$request->country,
            'city'=>$request->city,
            'address'=>$request->address,


        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('image/user_img/');
            $imageName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $user->image = $imageName;
        }

        $token=$user->createToken('token')->plainTextToken;

        return response()->json([

            'success' => true,
            'message' => 'User register successfully',
            'token' =>$token,

        ]);

    }
    

}
