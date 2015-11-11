<?php

// api for back end
Route::group(['prefix' => '/api'], function ()
{
    Route::group(['prefix' => '/auth'], function ()
    {
        Route::post('login', 'Api\AuthController@login');
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('confirm', 'Api\AuthController@confirm');
    });
});

// capture any undefined routes and pass to the CMS controller
Route::any('{catchall}', ['uses' => 'AlistairShaw\YewCMS\App\Http\Controllers\PageController@page'])->where('catchall', '(.*)');