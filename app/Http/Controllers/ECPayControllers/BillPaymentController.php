<?php

namespace App\Http\Controllers\ECPayControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Validator;

class BillPaymentController extends Controller
{
    
    public function test()
    {

        dd('Bills');

    }

}