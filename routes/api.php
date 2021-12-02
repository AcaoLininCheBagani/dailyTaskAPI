<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PersonController;


Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ],
    function($router){

        //ADMINS

        Route::post('/adminlogin',[AdminController::class, 'adminLogin']);
        Route::post('/createdadmin',[AdminController::class, 'createAdmin']);

        //PERSONS

        Route::post('/personlogin',[PersonController::class, 'personLogin']);
        Route::post('/createperson',[PersonController::class, 'createPerson']);
});


