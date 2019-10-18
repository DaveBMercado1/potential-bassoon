<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Service;
use App\User;
use Validator;
use Illuminate\Support\Arr;

class UserController extends Controller
{
 
    // Registration (For Test)
    public function register(Request $request)
    {

        //Validate Input
        $registerValidation = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required|starts_with:+|unique:users'
        ]);

        //Hash Password and Store
        $input = $request->all();
        $input['password'] = Hash::make($input['password']); 
        $user = User::create($input);

        //return if no errors
        return response()->json(['SUCCESS']);

    }

    // User Details
    public function UserDetails(Request $request) 
    {

        //Validate input
        $validator = /*Validator::make($request->all(),*/ [
            'email' => 'required|email',
            'password' => 'required',
        ]/*)*/;

        $messages = [
            'required' => 'Invalid Input: Empty Field',
            'email' => 'Invalid Input: Value must be in email format'
        ];

        $this->validate($request, $validator, $messages);

        // if($validator->fails()){
        //     return response()->json($validator->errors(), 400);
        // }

        //checks if user exists
        $userDetails = User::where('email', $request->email)->get();

        if($userDetails->count() == 0){
            return response()->json(["Invalid Input: Email is Incorrect"]);
        }

        //checks if password matches
        $password = User::where('email', $request->email)->get()->pluck('password');
        $password = $password[0];
        $passwordInput = $request->password;

        if(!Hash::check($passwordInput, $password)){
            return response() -> json(['Invalid Input: Password is Incorrect']);
        }

        // $random = Str::random(40);
        // dd($random);

        //return if no errors
        return response()->json(['Details' => $userDetails]);

    }
}