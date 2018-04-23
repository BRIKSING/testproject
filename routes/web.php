
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

  Route::get('/', function () {
      return view('index');
  });

  Route::get('/welcome',['as' => 'welc', function (Request $request) {
      return session()->get('error');
  }]);
  Route::post('/register', 'Api\RegisterController@register');
  Route::get('/login', 'Api\AuthController@login');
  Route::get('/user', 'Api\AuthController@GetUserInfo');
  Route::post('/userUpdate', 'Api\AuthController@userUpdate')->middleware('User_Middle');
  Route::post('/TaskCreate', 'Api\TaskController@TaskCreate');
  Route::post('/TaskUpdate', 'Api\TaskController@TaskUpdate');
  Route::get('/doings/{month}-{year}', 'Api\TaskController@NewGetTasks');
  Route::get('/deleting', 'Api\TaskController@TaskDelete');
  Route::get('/getPeriods', 'Api\PeriodController@getPeriodList');
  Route::get('/getPeriodName', 'Api\PeriodController@getPeriodNameById');
  //Route::post('/TaskDelete', 'Api\TaskController@TaskDelete');
