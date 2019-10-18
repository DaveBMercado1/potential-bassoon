<?php
use Illuminate\Http\Request;

/*|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {

    return $router->app->version();

});

$router->group(['prefix' => 'api/v1', 'middleware' => 'client'], function() use ($router){
 
 });

$router->post('/register', 'UserController@register');

$router->group(['middleware' => 'client'], function () use ($router) {

    $router->post('/user', 'UserController@UserDetails');

    $router->group(['prefix'=>'service'], function() use ($router){

        $router->get('/wavecell/{id}', 'ServiceController@OneTimePin');
        $router->post('/wavecell/validate/{uid}', 'ServiceController@ValidateOtp');
    
    });

});

$router->group(['prefix'=>'wu'], function() use ($router){

    $router->post('/sendmoney', 'WesternController@SendMoneyValidate');
    $router->get('/test', 'WesternController@heartbeat');
 
});

$router->group(['prefix'=>'ecp'], function() use ($router){

    $router->post('/test', 'ECPayControllers\CashInController@test');
    $router->get('/test2', 'ECPayControllers\BillPaymentController@test');
 
});