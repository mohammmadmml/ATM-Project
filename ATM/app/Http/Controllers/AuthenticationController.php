<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Card;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class AuthenticationController extends Controller
{
    public function register(Request $request){
        if(!empty(User::where('email',$request->email)->exists())){
            return response()->json(['message','email already exist'],409);
        }else{
            if($request->password !== $request->password_confirmation){
                return response()->json(['message','password doesnt match'],400);
            }
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),

            ]);
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'success'=>$token,
                'message'=>'token created successfully',
            ],200);
            echo 'user created successfully';
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:6'
        ]);
        if($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()],422);
        }
        $token = auth('api')->attempt(([
            'email'=>$request->email,
            'password'=>$request->password,
        ]));

        if($token){
            return response()->json([
                'success'=>$token,
                'message'=>'User logged in successfully',
            ]);
        }else{
            return response()->json(['errors'=>'UnAuthorissed Access'],401);}
    }
    public function ChangePassword(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'old_password'        =>'required',
            'new_password'         =>'required|min:6|max:30',
            'confirm_password' =>'required|same:new_password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=>'validations fails',
                'errors' =>$validator->errors()
            ],422);
        }
        $user=$request->user();

        if (Hash::check($request->old_password,$user->password)) {
            $user->update([
                'password'=>Hash::make($request->new_password)
            ]);


            return response()->json([
                'message'=>' password successfully updated',
                'errors' =>$validator->errors()
            ],200);
        }
        else
        {
            return response()->json([
                'message'=>'old password does not match',
                'errors' =>$validator->errors()
            ],422);
        }
    }
}

