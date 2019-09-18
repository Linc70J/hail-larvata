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

Route::get('/', function (){
    return 'test';
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

Route::group(array('prefix' => config('administrator.uri'), 'middleware' => 'App\Http\Middleware\ValidateAdmin'), function () {

    //Admin Dashboard
    Route::get('/', array(
        'as'   => 'admin_dashboard',
        'uses' => 'AdminController@dashboard',
    ));

    //File Downloads
    Route::get('file_download', array(
        'as'   => 'admin_file_download',
        'uses' => 'AdminController@fileDownload',
    ));

    //Custom Pages
    Route::get('page/{page}', array(
        'as'   => 'admin_page',
        'uses' => 'AdminController@page',
    ));

    Route::group(array('middleware' => ['App\Http\Middleware\ValidateSettings', 'App\Http\Middleware\PostValidate']), function () {
        //Settings Pages
        Route::get('settings/{settings}', array(
            'as'   => 'admin_settings',
            'uses' => 'AdminController@settings',
        ));

        //Display a settings file
        Route::get('settings/{settings}/file', array(
            'as'   => 'admin_settings_display_file',
            'uses' => 'AdminController@displayFile',
        ));

        //Save Item
        Route::post('settings/{settings}/save', array(
            'as'   => 'admin_settings_save',
            'uses' => 'AdminController@settingsSave',
        ));

        //Custom Action
        Route::post('settings/{settings}/custom_action', array(
            'as'   => 'admin_settings_custom_action',
            'uses' => 'AdminController@settingsCustomAction',
        ));

        //Settings file upload
        Route::post('settings/{settings}/{field}/file_upload', array(
            'as'   => 'admin_settings_file_upload',
            'uses' => 'AdminController@fileUpload',
        ));
    });

    //Switch locales
    Route::get('switch_locale/{locale}', array(
        'as'   => 'admin_switch_locale',
        'uses' => 'AdminController@switchLocale',
    ));

    //The route group for all other requests needs to validate admin, model, and add assets
    Route::group(array('middleware' => ['App\Http\Middleware\ValidateModel', 'App\Http\Middleware\PostValidate']), function () {

        //Model Index
        Route::get('{model}', array(
            'as'   => 'admin_index',
            'uses' => 'AdminController@index',
        ));

        //New Item
        Route::get('{model}/new', array(
            'as'   => 'admin_new_item',
            'uses' => 'AdminController@item',
        ));

        //Update a relationship's items with constraints
        Route::post('{model}/update_options', array(
            'as'   => 'admin_update_options',
            'uses' => 'AdminController@updateOptions',
        ));

        //Display an image or file field's image or file
        Route::get('{model}/file', array(
            'as'   => 'admin_display_file',
            'uses' => 'AdminController@displayFile',
        ));

        //Updating Rows Per Page
        Route::post('{model}/rows_per_page', array(
            'as'   => 'admin_rows_per_page',
            'uses' => 'AdminController@rowsPerPage',
        ));

        //Get results
        Route::post('{model}/results', array(
            'as'   => 'admin_get_results',
            'uses' => 'AdminController@results',
        ));

        //Custom Model Action
        Route::post('{model}/custom_action', array(
            'as'   => 'admin_custom_model_action',
            'uses' => 'AdminController@customModelAction',
        ));

        //Get Item
        Route::get('{model}/{id}', array(
            'as'   => 'admin_get_item',
            'uses' => 'AdminController@item',
        ));

        //File Uploads
        Route::post('{model}/{field}/file_upload', array(
            'as'   => 'admin_file_upload',
            'uses' => 'AdminController@fileUpload',
        ));

        //Save Item
        Route::post('{model}/{id?}/save', array(
            'as'   => 'admin_save_item',
            'uses' => 'AdminController@save',
        ));

        //Delete Item
        Route::post('{model}/{id}/delete', array(
            'as'   => 'admin_delete_item',
            'uses' => 'AdminController@delete',
        ));

        //Custom Item Action
        Route::post('{model}/{id}/custom_action', array(
            'as'   => 'admin_custom_model_item_action',
            'uses' => 'AdminController@customModelItemAction',
        ));

        //Batch Delete Item
        Route::post('{model}/batch_delete', array(
            'as'   => 'admin_batch_delete',
            'uses' => 'AdminController@batchDelete',
        ));
    });
});
