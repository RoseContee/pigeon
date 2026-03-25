<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'App\Http\Controllers',
], function() {

    Route::get('/', 'IndexController@index')->name('index');

    Route::get('terms', 'IndexController@terms')->name('terms');
    Route::get('privacy', 'IndexController@privacy')->name('privacy');
	Route::get('how', 'IndexController@how')->name('how');

    Route::get('verify-email/{name}', 'AuthController@verifyEmail')->name('verify-email');

    Route::group([
        'middleware' => ['guest'],
    ], function() {
        Route::get('login', 'AuthController@login')->name('login');
        Route::post('login', 'AuthController@postLogin');

        Route::get('forgot-password', 'AuthController@forgot')->name('forgot-password');
        Route::post('forgot-password', 'AuthController@postForgot');

        Route::get('reset-password/{name}', 'AuthController@reset')->name('reset-password');
        Route::post('reset-password/{name}', 'AuthController@postReset');

        Route::get('signup', 'AuthController@signup')->name('signup');
        Route::post('signup', 'AuthController@postSignup');

        Route::get('auth/google', 'SocialAuthController@authGoogle')->name('auth-google');
        Route::get('auth/google/callback', 'SocialAuthController@authGoogleCallback');

        //Route::get('auth/linkedin', 'SocialAuthController@authLinkedIn')->name('auth-linkedin');
        //Route::get('auth/linkedin/callback', 'SocialAuthController@authLinkedInCallback');
    });

    Route::group([
        'middleware' => ['auth']
    ], function() {
        Route::get('dashboard', 'HomeController@dashboard')->name('home');

        Route::get('profile', 'HomeController@profile')->name('profile');
        Route::post('profile', 'HomeController@postProfile');

        Route::get('meetings', 'HomeController@meetings')->name('meetings');

        Route::get('guests', 'HomeController@guests')->name('guests');
        Route::get('guest/add', 'HomeController@addGuest')->name('add-guest');
        Route::post('guest/add', 'HomeController@postAddGuest');
        Route::get('guest/{name}', 'HomeController@editGuest')->name('edit-guest');
        Route::post('guest/{name}', 'HomeController@postEditGuest');
        Route::delete('guest/delete', 'HomeController@deleteGuest')->name('delete-guest');

        Route::get('apps', 'HomeController@apps')->name('apps');
        Route::get('app/{name}', 'HomeController@editApp')->name('edit-app');
        Route::post('app/{name}', 'HomeController@postEditApp');

        Route::get('membership', 'HomeController@membership')->name('membership');

        Route::get('logout', function() {
            Auth::logout();
            return redirect()->route('index');
        })->name('logout');
    });


    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin',
    ], function() {
        Route::group([
            'middleware' => ['guest:admin'],
        ], function() {
            Route::get('login', 'AuthController@login')->name('admin.login');
            Route::post('login', 'AuthController@postLogin');

            Route::get('forgot-password', 'AuthController@forgot')->name('admin.forgot-password');
            Route::post('forgot-password', 'AuthController@postForgot');

            Route::get('reset-password/{name}', 'AuthController@reset')->name('admin.reset-password');
            Route::post('reset-password/{name}', 'AuthController@postReset');

            Route::get('verify-email/{name}', 'AuthController@verifyEmail')->name('admin.verify-email');
        });

        Route::group([
            'middleware' => ['auth:admin'],
        ], function() {
            Route::get('/', 'HomeController@dashboard')->name('admin');

            Route::get('platforms', 'HomeController@platforms')->name('admin.platforms');
            Route::post('platform/active', 'HomeController@activePlatform')->name('admin.active-platform');
            Route::delete('platform/delete', 'HomeController@deletePlatform')->name('admin.delete-platform');
            Route::get('platform/add', 'HomeController@editPlatform')->name('admin.add-platform');
            Route::post('platform/add', 'HomeController@postEditPlatform');
            Route::get('platform/edit/{id}', 'HomeController@editPlatform')->name('admin.edit-platform');
            Route::post('platform/edit/{id}', 'HomeController@postEditPlatform');

            Route::get('apps', 'HomeController@apps')->name('admin.apps');
            Route::post('app/active', 'HomeController@activeApp')->name('admin.active-app');
            Route::delete('app/delete', 'HomeController@deleteApp')->name('admin.delete-app');
            Route::get('app/add', 'HomeController@editApp')->name('admin.add-app');
            Route::post('app/add', 'HomeController@postEditApp');
            Route::get('app/edit/{id}', 'HomeController@editApp')->name('admin.edit-app');
            Route::post('app/edit/{id}', 'HomeController@postEditApp');

            Route::get('words', 'HomeController@words')->name('admin.words');
            Route::delete('word/delete', 'HomeController@deleteWord')->name('admin.delete-word');
            Route::get('word/add', 'HomeController@editWord')->name('admin.add-word');
            Route::post('word/add', 'HomeController@postEditWord');
            Route::get('word/edit/{id}', 'HomeController@editWord')->name('admin.edit-word');
            Route::post('word/edit/{id}', 'HomeController@postEditWord');

            Route::get('packages', 'HomeController@packages')->name('admin.packages');
            Route::post('package/active', 'HomeController@activePackage')->name('admin.active-package');
            Route::delete('package/delete', 'HomeController@deletePackage')->name('admin.delete-package');
            Route::get('package/add', 'HomeController@editPackage')->name('admin.add-package');
            Route::post('package/add', 'HomeController@postEditPackage');
            Route::get('package/edit/{id}', 'HomeController@editPackage')->name('admin.edit-package');
            Route::post('package/edit/{id}', 'HomeController@postEditPackage');

            Route::get('memberships', 'HomeController@memberships')->name('admin.memberships');
            Route::post('membership/active', 'HomeController@activeMembership')->name('admin.active-membership');
            Route::delete('membership/delete', 'HomeController@deleteMembership')->name('admin.delete-membership');
            Route::get('membership/add', 'HomeController@editMembership')->name('admin.add-membership');
            Route::post('membership/add', 'HomeController@postEditMembership');
            Route::get('membership/edit/{id}', 'HomeController@editMembership')->name('admin.edit-membership');
            Route::post('membership/edit/{id}', 'HomeController@postEditMembership');

            Route::get('users', 'HomeController@users')->name('admin.users');
            Route::post('user/limitation', 'HomeController@userLimitation')->name('admin.user-limitation');
            Route::post('user/active', 'HomeController@activeUser')->name('admin.active-user');
            Route::delete('user/delete', 'HomeController@deleteUser')->name('admin.delete-user');
            Route::get('user/add', 'HomeController@editUser')->name('admin.add-user');
            Route::post('user/add', 'HomeController@postEditUser');
            Route::get('user/edit/{id}', 'HomeController@editUser')->name('admin.edit-user');
            Route::post('user/edit/{id}', 'HomeController@postEditUser');

            Route::get('user/{id}/guests', 'HomeController@userGuests')->name('admin.user-guests');
            Route::delete('user/{id}/guest/delete', 'HomeController@deleteGuest')->name('admin.delete-user-guest');
            Route::get('user/{id}/guest/add', 'HomeController@addUserGuest')->name('admin.add-user-guest');
            Route::post('user/{id}/guest/add', 'HomeController@postAddUserGuest');
            Route::get('user/{id}/guest/edit/{guest_id}', 'HomeController@addUserGuest')->name('admin.edit-user-guest');
            Route::post('user/{id}/guest/edit/{guest_id}', 'HomeController@postAddUserGuest');

            Route::get('user/{id}/meetings', 'HomeController@userMeetings')->name('admin.user-meetings');

            Route::get('setting', 'HomeController@setting')->name('admin.setting');
            Route::post('setting', 'HomeController@postSetting');

            Route::get('profile', 'HomeController@profile')->name('admin.profile');
            Route::post('profile', 'HomeController@postProfile');

            Route::get('logout', function() {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login');
            })->name('admin.logout');
        });
    });
});