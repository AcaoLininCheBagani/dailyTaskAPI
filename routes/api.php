<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\TaskController;

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

        //////////-----TASK----//////////
        //CREATE
        Route::post('/createtask',[TaskController::class, 'createTask']);
        //READ
        Route::get('/viewtask',[TaskController::class, 'viewTask']);
        //UPDATE
        Route::put('/updatetask/{id}',[TaskController::class,'updateTask']);
        //DELETE
        Route::delete('/deletetask/{id}',[TaskController::class,'deleteTask']);
        //CHECK AUTH USR
        Route::post('/check',[TaskController::class,'check']);


});






