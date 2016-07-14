<?php
use App\model\DB\Category;
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

//Route::controller('users', 'UserController');
Route::get('/', 'UserController@getIndex');
/*Route::get('user/register', 'UserController@register');
Route::get('user/index', 'UserController@index');*/
//Route::post('auth/create', 'Auth\AuthController@postRegister');
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister'); //view auth/register
Route::post('auth/register', 'Auth\AuthController@postRegister'); //receive data from registration form
Route::get('auth/active', 'Auth\AuthController@postActivate'); //activate user account

//Route::controller('user', 'UserController');
//Route::controller('promise', ['middleware' => 'auth', 'uses' => 'PromiseController']);

Route::get('home','UserController@getIndex'); //maby page for quest

//Promise buy routes
Route::get('promise/buy','PromiseController@promiseBuy'); //display all promise
Route::get('promise/buy/{id}','PromiseController@promiseCat'); //display promise in select category
Route::get('promise/details/{id}','PromiseController@promiseDetails'); //display promise detailes




Route::group(['middleware' => ['auth']], function(){
   // Route::get('/promise/index', 'PromiseController@getIndex');
   // Route::get('/promise/validation', 'PromiseController@validation');

    //Route::get('/promise/buy', 'PromiseController@pageBuy');
    Route::get('/promise/profile/{id}', 'PromiseController@pageProfile');
    Route::get('/promise/buypromise', 'PromiseController@pageBuypromise');

    //profile route
    Route::get('/account','AccountController@getIndex');
    Route::get('/account/broughtpromise', 'AccountController@pageBroughtpromise');
    Route::get('/account/otherpromise', 'AccountController@pageOtherpromise');
    Route::get('/account/sellpromise', 'AccountController@pageSellpromise');
    Route::get('/account/yourpromise', 'AccountController@pageYourpromise');
    Route::get('/account/requeste','AccountController@requestePromise');

    //promise route
    //Route::post('/promise/add', 'PromiseController@add'); старый метод сохранения Promise
    Route::post('/promise/addrequest', 'PromiseController@addRequest');
    Route::post('/promise/getdata', 'PromiseController@getData');
    Route::post('/promise/buy', 'PromiseController@buy'); //buy promise
    Route::post('/promise/auction', 'PromiseController@buyAuction'); //bit auction promise
    Route::post('/promise/check', 'PromiseController@check');
    Route::post('/promise/getpromisebycategory', 'PromiseController@getPromiseByCategory');

    Route::get('/promise/sell', 'PromiseController@pageSell'); //sell promise
    Route::post('/promise/sell', 'PromiseController@add'); //sell promise
    
    //Route::get('/promise/request','PromiseController')//Promise request
    Route::get('/promise/request', 'PromiseController@pageRequest');
    Route::post('/promise/request', 'PromiseController@pageRequest');
    //Route::post('/promise/request', 'PromiseController@addRequest');


    Route::get('/home','UserController@getIndex');

    Route::get('/user/getfile','UserController@uploadedFile');

 

});

Route::group(['middleware' => ['auth','admin']], function() { //group for admin
    //Route::get('/admin', 'AdminController@users'); //old route
    //admin defoult route
    Route::get('/admin', 'AdminController@getIndex'); //i add
    /*Users route*/
    Route::get('/admin/users','AdminUsersController@users');   //display default data  =>i add
    Route::post('/admin/users','AdminUsersController@modify'); //display modify data  =>i add
    Route::get('/admin/users/new','AdminUsersController@newUser');
    /* ./Users route*/
    /* Category route*/
    Route::get('/admin/category','AdminCategoryController@getCategory');
    Route::post('/admin/category','AdminCategoryController@modify');
    /* ./Category route*/
    /* ./Location*/
    Route::get('/admin/location','AdminLocationController@getIndex');
    Route::post('/admin/location','AdminLocationController@modify');
    /* ./Location*/
    /*Primese*/
    Route::get('/admin/promise', 'AdminPromiseController@pagePromise');

    /* ./Promise*/
   // Route::get('/admin/users', 'AdminController@users'); //old route
   // Route::get('/admin/promise', 'AdminController@promise'); old route
});

/*Route::get('/', function () {
    return view('welcome');
});*/
