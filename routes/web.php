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

//signin
Route::get('/users/signin', [
    'uses' => 'UsersController@getSignin',
    'as' => 'users.signin'
]);

Route::post('/users/signin', [
    'uses' => 'UsersController@postSignin',
    'as' => 'users.signin'
]);

Route::group(['middleware' => 'auth'] , function () {

    Route::get('/users/logout', [
        'uses' => 'UsersController@getLogout',
        'as' => 'users.logout'
    ]);
    
    Route::get('/', [
        'uses' => 'DashboardController@index' , 
        'as' => 'dashboard.index'
    ]);

    // Groups
    Route::get('/groups', [
        'uses' => 'GroupsController@index' , 
        'as' => 'groups.index'
    ]);
    
    Route::post('/groups/store', [
        'uses' => 'GroupsController@store' , 
        'as' => 'groups.store'
    ]);
    
    Route::get('/groups/{id}/edit', [
        'uses' => 'GroupsController@edit' , 
        'as' => 'groups.edit'
    ]);

    Route::match(array('PUT', 'PATCH'), '/groups/{id}', [
        'uses' => 'GroupsController@update' , 
        'as' => 'groups.update'
    ]);

    Route::delete('/groups/{id}', [
        'uses' => 'GroupsController@destroy' , 
        'as' => 'groups.destroy'
    ]);

    // Contacts
    Route::get('/contacts', [
        'uses' => 'ContactsController@index' , 
        'as' => 'contacts.index'
    ]);
    
    Route::post('/contacts/store', [
        'uses' => 'ContactsController@store' , 
        'as' => 'contacts.store'
    ]);

    Route::delete('/contacts/{id}', [
        'uses' => 'ContactsController@destroy' , 
        'as' => 'contacts.destroy'
    ]);

    Route::get('/contacts/{id}/edit', [
        'uses' => 'ContactsController@edit' , 
        'as' => 'contacts.edit'
    ]);

    Route::match(array('PUT', 'PATCH'), '/contacts/{id}', [
        'uses' => 'ContactsController@update' , 
        'as' => 'contacts.update'
    ]);

    // Compose
    Route::get('/compose', [
        'uses' => 'SmsController@compose' , 
        'as' => 'compose.index'
    ]);

    // Send message
    Route::post('/compose/sendmsg', [
        'uses' => 'SmsController@sendmsg',
        'as' => 'compose.sendmsg'
    ]);

    Route::get('/sent', [
        'uses' => 'SmsController@sent' , 
        'as' => 'sent.index'
    ]);
});