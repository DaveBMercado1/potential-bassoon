<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Validator;

class WesternController extends Controller
{

    //Fee Inquiry Request and Reply
    public function FeeInquiry(Request $request)
    {

        //User Inputs
        $validator = $this -> validate($request, [

            'originatingCountry'=>'Required',
            'destinationCountry' => 'Required',
            'paymentType' => 'Required',
            'transactionType' => 'Required',
 
            'taxAmount' => 'Required',
            'gross_total_amount' => 'Required',
            'plus_charges_amount' => 'Required',
            'charges' => 'Required',
            'payAmount' => 'Required',
            'tolls' => 'Required',

            'identifier' => 'Required',
            'reference_no' => 'Required',
            'counter_id' => 'Required',
            'operator_id' => 'Required',

        ]);
 
        $input = $request -> all();

        //Send Validate Request
        $guzzle = new Client([
            'headers' => [
                'Content-Type' => 'text/xml',
                'Host' => config('IpayConfig/services.WU_API_HOST')
            ]
        ]);

        $params =
            '<xrsi:esp-server-heartbeat-request xmlns:xrsi="http://www.westernunion.com/schema/xrsi">

                <Channel>
                    <name>Mobile</name>
                </Channel>

                <payment_details>
                    <originating_country>'.$input['originatingCountry'].'</originating_country>
                    <destination_country>'.$input['destinationCountry'].'</destination_country>
                    <payment_type>'.$input['paymentType'].'</payment_type>
                    <transaction_type>'.$input['transactionType'].'</transation_type>
                </payment_details>

                <financials>
                    <Taxes>
                        <tax_amount>'.$input['taxAmount'].'</tax_amount>
                    </Taxes>
                    <gross_total_amount>'.$input['gross_total_amount'].'</gross_total_amount>
                    <plus_charges_amount>'.$input['plus_charges_amount'].'</plus_charges_amount>
                    <pay_amount>'.$input['payAmount'].'</pay_amount>
                    <Tolls>'.$input['tolls'].'</Tolls>
                </financials>

                <foreign_remote_system>
                    <Identifier>'.env('WU_API_FSID').'</Identifier>
                    <counter_id>'.env('WU_API_TERM_ID').'</counter_id>
                </foreign_remote_system>

            </xrsi:esp-server-heartbeat-request>';

        $res = $guzzle ->post(env('WU_API_URL'), [
            'Body' => $params
        ]);

        //Return Validate Reply
        return response()->xml($res);

    }

    //Validate Request and Reply
    public function SendMoneyValidate(Request $request)
    {

        //User Inputs
        $validator = $this -> validate($request, [

            'senderName' => 'Required',
            'senderPhone' => 'Required',
            'senderPostal' => 'Required',
            'senderAddress' => 'Required',

            'recieverName' => 'Required',
            'recieverPhone' => 'Required',
            'recieverPostal' => 'Required',
            'recieverAddress' => 'Required',

            'originatingCountry'=>'Required',
            'destinationCountry' => 'Required',
            'paymentType' => 'Required',
            'transactionType' => 'Required',

            'taxAmount' => 'Required',
            'gross_total_amount' => 'Required',
            'plus_charges_amount' => 'Required',
            'charges' => 'Required',
            'payAmount' => 'Required',
            'tolls' => 'Required',

            'identifier' => 'Required',
            'reference_no' => 'Required',
            'counter_id' => 'Required',
            'operator_id' => 'Required',

        ]);

        $input = $request -> all();

        //Send Validate Request
        $guzzle = new Client([
            'headers' => [
                'Content-Type' => 'text/xml',
                'Host' => config('IpayConfig/services.WU_API_HOST')
            ]
        ]);

        $params =
            '<xrsi:esp-server-heartbeat-request xmlns:xrsi="http://www.westernunion.com/schema/xrsi">
            
                <Channel>
                    <name>Mobile</name>
                </Channel>

                <Sender>
                    <name>'.$input['senderName'].'</name>
                    <PhoneNumber>'.$input['senderPhone'].'</PhoneNumber>
                    <PostalCode>'.$input['senderPostal'].'</PostalCode>
                    <Address>'.$input['senderAddress'].'</Address>
                </Sender>

                <Receiver>
                    <name>'.$input['receiverName'].'</name>
                    <PhoneNumber>'.$input['receiverPhone'].'</PhoneNumber>
                    <PostalCode>'.$input['receiverPostal'].'</PostalCode>
                    <Address>'.$input['receiverAddress'].'</Address>
                </Receiver>

                <payment_details>
                    <originating_country>'.$input['originatingCountry'].'</originating_country>
                    <destination_country>'.$input['destinationCountry'].'</destination_country>
                    <payment_type>'.$input['paymentType'].'</payment_type>
                    <transaction_type>'.$input['transactionType'].'</transation_type>
                </payment_details>

                <financials>
                    <Taxes>
                        <tax_amount>'.$input['taxAmount'].'</tax_amount>
                    </Taxes>
                    <gross_total_amount>'.$input['gross_total_amount'].'</gross_total_amount>
                    <plus_charges_amount>'.$input['plus_charges_amount'].'</plus_charges_amount>
                    <pay_amount>'.$input['payAmount'].'</pay_amount>
                    <Tolls>'.$input['tolls'].'</Tolls>
                </financials>

                <foreign_remote_system>
                    <Identifier>'.env('WU_API_FSID').'</Identifier>
                    <counter_id>'.env('WU_API_TERM_ID').'</counter_id>
                </foreign_remote_system>

            </xrsi:esp-server-heartbeat-request>';

        $res = $guzzle ->post(env('WU_API_URL'), [
            'Body' => $params
        ]);

        //Return Validate Reply
        return response()->xml($res);

    }

    //Store Request and Reply
    public function SendMoneyStore()
    {

        //User Inputs
        $validator = $this -> validate($request, [

            'senderName' => 'Required',
            'senderPhone' => 'Required',
            'senderPostal' => 'Required',
            'senderAddress' => 'Required',

            'recieverName' => 'Required',
            'recieverPhone' => 'Required',
            'recieverPostal' => 'Required',
            'recieverAddress' => 'Required',

            'originatingCountry'=>'Required',
            'destinationCountry' => 'Required',
            'paymentType' => 'Required',
            'transactionType' => 'Required',

            'taxAmount' => 'Required',
            'gross_total_amount' => 'Required',
            'plus_charges_amount' => 'Required',
            'charges' => 'Required',
            'payAmount' => 'Required',
            'tolls' => 'Required',

            'identifier' => 'Required',
            'reference_no' => 'Required',
            'counter_id' => 'Required',
            'operator_id' => 'Required',

            'mtcn' => 'Required',
            'new_mtcn' => 'Required',

        ]);

        $input = $request -> all();

        //Send Store Request
        $guzzle = new Client([
            'headers' =>[
                'Content-Type' => 'text/xml; charset=UTF8',
                'Host' => config('IpayConfig/services.WU_API_HOST')
            ]
        ]);

        $params =
            '<xrsi:esp-server-heartbeat-request xmlns:xrsi="http://www.westernunion.com/schema/xrsi">

                <Channel>
                    <name>Mobile</name>
                </Channel>

                <Sender>
                    <name>'.$input['senderName'].'</name>
                    <PhoneNumber>'.$input['senderPhone'].'</PhoneNumber>
                    <PostalCode>'.$input['senderPostal'].'</PostalCode>
                    <Address>'.$input['senderAddress'].'</Address>
                </Sender>

                <Receiver>
                    <name>'.$input['receiverName'].'</name>
                    <PhoneNumber>'.$input['receiverPhone'].'</PhoneNumber>
                    <PostalCode>'.$input['receiverPostal'].'</PostalCode>
                    <Address>'.$input['receiverAddress'].'</Address>
                </Receiver>

                <payment_details>
                    <originating_country>'.$input['originatingCountry'].'</originating_country>
                    <destination_country>'.$input['destinationCountry'].'</destination_country>
                    <payment_type>'.$input['paymentType'].'</payment_type>
                    <transaction_type>'.$input['transactionType'].'</transation_type>
                </payment_details>

                <financials>
                    <Taxes>
                        <tax_amount>'.$input['taxAmount'].'</tax_amount>
                        <gross_total_amount>'.$input['gross_total_amount'].'</gross_total_amount>
                        <plus_charges_amount>'.$input['plus_charges_amount'].'</plus_charges_amount>
                        <pay_amount>'.$input['payAmount'].'</pay_amount>
                        <Tolls>'.$input['tolls'].'</Tolls>
                    </Taxes>
                </financials>

                <foreign_remote_system>
                    <Identifier>'.env('WU_API_FSID').'</Identifier>
                    <counter_id>'.env('WU_API_TERM_ID').'</counter_id>
                </foreign_remote_system>

                <mtcn>'.$input['mtcn'].'</mtcn>
                <new_mtcn>'.$input['new_mtcn'].'</new_mtcn>

            </xrsi:esp-server-heartbeat-request>';

        $res = $guzzle ->post(env('WU_API_URL'), [
            'Body' => $params
        ]);

        //Return Store Reply
        return response()->xml($res);

    }

    //Connection Test
    public function heartbeat(){

        // dd('123');

        $headers = [
            'Content-Type' => 'text/xml; charset=UTF8',
            'Host' => config('IpayConfig/services.WU_API_HOST')
        ];

        dd($headers);

        $guzzle = new Client([
            'headers' => $headers
        ]);

        $params = 
        '<xrsi:esp-server-heartbeat-request xmlns:xrsi="http://www.westernunion.com/schema/xrsi"> 

                <partner>
                    <id>'.env('WU_API_FSID').'</id>
                </partner>
                <device>
                    <type>MOBILE</type>
                </device>
                <id>'.env('WU_API_FTID').'</id>

        </xrsi:esp-server-heartbeat-request>';

        $res = $guzzle->post(env('WU_API_URL'), [
            'body' => $params
        ]);

        dd($res);

        // return json_decode($res->getBody(), true);

    }

}