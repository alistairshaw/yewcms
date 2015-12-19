<?php

// api for back end
Route::group(['prefix' => '/api', 'namespace' => 'AlistairShaw\YewCMS\App\Http\Controllers'], function ()
{
    Route::group(['prefix' => '/auth'], function ()
    {
        Route::post('login', 'Api\AuthController@login');
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('confirm', 'Api\AuthController@confirm');
    });

    Route::resource('user', 'Api\UserController');
});

// capture any undefined routes and pass to the CMS controller
Route::any('{catchall}', ['uses' => 'AlistairShaw\YewCMS\App\Http\Controllers\PageController@page'])->where('catchall', '(.*)');