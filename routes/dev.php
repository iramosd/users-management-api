<?php
use App\Http\Controllers\dev\ConsoleController;
use Illuminate\Support\Facades\Route;

route::group(['prefix' => '/dev', 'as' => 'dev.'], function () {
    route::get('/console', ConsoleController::class);
});
