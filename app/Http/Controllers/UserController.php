<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'failed', 'validation_errors' => $validator->errors()]);
        }

        $inputs = $request->all();

        $inputs['password'] = Hash::make($request->password);

        $user = User::create($inputs);

        if(!is_null($user)){
            return response()->json(['status' => 'success', 'message' => 'User registration Successfull!', 'data'=>$user]);
        }else{
            return response()->json(['status'=>'failed', 'message'=>'Registration Failed']);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 'failed', 'validation_errors'=>$validator->errors()]);
        }

        $user = User::where('email',$request->email)->first();

        if(is_null($user)){
            return response()->json(['status'=>'failed','message'=>'Failed! User Not Fonud!']);
        }

        if(Auth::attempt(['email'=> $request->email, 'password'=> $request->password])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;

            return response()->json(['status'=>'success', 'login'=>true, 'token'=>$token, 'data'=>$user]);
        }else{
            return response()->json(['status'=>'failed', 'success'=>false, 'message'=>'Wooppss! Invalid Password!']);
        }
    }
}
