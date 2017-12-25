<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$router->get('/', 'WelcomeController@index');

$router->get('/home', 'HomeController@index');

$router->get('services/{id}', 'ServiceController@ShowService');
$router->get('services/terminate/{id}', 'ServiceController@TerminateService');
$router->get('return', function(){
   echo '<pre>';
   echo print_r($_SERVER);
   echo '</pre>'; 
});
$router->get('support', 'SupportController@Index');
$router->get('support/tickets/{id}', 'SupportController@ShowSingle');
$router->get('support/create', 'SupportController@GET_Create');

$router->post('support/create', 'SupportController@POST_Create');


$router->get('update/db/', 'UpdateController@UpdateTickets');

//License Management URLs
$router->get('license/reset/{id}', 'ServiceController@resetLicense');

/*
|--------------------------------------------------------------------------
| Authentication & Password Reset Controllers
|--------------------------------------------------------------------------
|
| These two controllers handle the authentication of the users of your
| application, as well as the functions necessary for resetting the
| passwords for your users. You may modify or remove these files.
|
*/

$router->controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
