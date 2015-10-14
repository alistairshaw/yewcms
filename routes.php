<?php

// capture any undefined routes and pass to the CMS controller
Route::any('{catchall}', ['uses' => 'AlistairShaw\YewCMS\App\Http\Controllers\PageController@page'])->where('catchall', '(.*)');