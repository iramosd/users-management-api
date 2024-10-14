<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

//routes for testing and development on local environment only
if(config('app.env') === 'local') {
    require __DIR__.'/dev.php';
}
