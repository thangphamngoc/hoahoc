<?php

use Facade\FlareClient\Stacktrace\File;
use Faker\Provider\File as ProviderFile;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Support\Facades\File as FacadesFile;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('storage/{filename}', function ($filename) {
        $path = storage_path('public/' . $filename);
        if (!TestingFile::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', function () {
        return App\User::all();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    // manager nick
    Route::post('nick/add', 'NickFbController@store');
    Route::get('nick/data', 'NickFbController@index');
    Route::put('nick/update', 'NickFbController@update');
    Route::get('nick/detail-day', 'NickFbController@detailAddDay');
    Route::post('nick/create-add-day', 'NickFbController@createAddDay');
    Route::get('nick/view-detail-day/{id}', 'NickFbController@viewAddDay');

    Route::get('nick/detail-add-day', 'NickFbController@addDayDetail');
    //end manager nick

    // manager ctv
    Route::post('ctv/add', 'InfoEmployeeController@store');
    Route::get('ctv/data', 'InfoEmployeeController@index');
    Route::put('ctv/update', 'InfoEmployeeController@update');
    //end manager ctv

    // total day
    Route::post('total/add', 'TotalDayController@store');
    Route::get('total/data', 'TotalDayController@index');
    Route::put('total/update', 'TotalDayController@update');
    //end total day

    //home
    Route::get('home/data', 'HomeController@staticsAdd');
    Route::get('home/post', 'HomeController@searchPost');
    

    //end home

    //post
    Route::post('post/add', 'PostController@store');
    Route::get('post/data', 'PostController@index');
    Route::put('post/update/{id}', 'PostController@update');
    Route::put('post/delete/{id}', 'PostController@deletePost');
    // endPost

    // statistic
    Route::get('statistic/month', 'StatisticController@indexMonth');
    //end statistic





});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
