<?php

namespace App\Http\Controllers\ECPayControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Validator;

class CashInController extends Controller
{

    public function test(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'number' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

    }

}