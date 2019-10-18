<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\User;
use Validator;

class ServiceController extends Controller
{

    //OTP Function
    public function OneTimePin($id)
    {

        //Get user phone number
        $phone = User::where('id', $id)->get()->pluck('phone_number');
        $phone = $phone[0];

        //Post to Wavecell API
        $guzzle = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('WAVECELL_API_TOKEN')
            ]
        ]);

        $params = [
            "destination" => $phone,
            "codeLength" => 6,
            // "productname" => "IPAY",
            "codeValidity" => 180,
            "createNew" => true,
            // "template" => [
            //     "source" => "IPAY",
            //     "text" => "Your code is {code}. It will remain valid for 3 minutes. Thank you",
            //     "encoding" => "AUTO"
            // ]
        ];

        $res = $guzzle -> post(env('WAVECELL_API_URL_OTP'), [
            'json' => $params
        ]);

        //return if no errors
        return json_decode($res->getBody(), true);

    }
 
    //Validate OTP
    public function ValidateOtp(Request $request,$uid){

        //Validate input
        $validate = /*Validator::make($request->all(),*/ [
            'pin' => 'required|numeric|digits:6'
        ]/*)*/;

        $messages = [
            'required' => 'Invalid Input: Empty Field',
            'numeric' => 'Invalid Input: Value must be Numeric',
            'digits' => 'Invalid Input: Value must be 6 Digits'
        ];

        $this->validate($request, $validate, $messages);
 
        // if($validator->fails()){
        //     return response()->json($validator->errors(), 400);
        // }

        //Get from Wavecell API
        $otp = $request->pin;
        $url = env('WAVECELL_API_URL_OTP')."/".$uid."?code=".$otp;
    
        $guzzle = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('WAVECELL_API_TOKEN')
            ]
        ]);

        $res = $guzzle -> get($url);
        // $arr = json_decode($res->getBody(), 200);
        // dd($arr['status']);
    
        //return if no errors
        return json_decode($res->getBody(), 200);

    }

}