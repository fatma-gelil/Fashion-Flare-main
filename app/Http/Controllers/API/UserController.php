<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Traits\MsgTrait;
class UserController extends Controller
{
    public function register(Request $request)
    {
       $validator = Validator::make($request->all(),[
           'email'=>'required|email',
           'password'=>'required',
           'c_password'=>'required|same:password'
       ]);
       if($validator->fails()){
           return MsgTrait::errorMessage([], 'Validation Error', 404);
       }
       $input = $request->all();
       $input['password'] = bcrypt($input['password']);
       $user = User::create($input);
           return MsgTrait::successMessage('User Register Successfully', 201);

    }
    public function login(Request $request)
    {
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user=Auth::user();
            return MsgTrait::successMessage('User Login Successfully', 201);

        }
        else{
            return MsgTrait::errorMessage([], 'Unauthorised', 404);

        }
    }
}
