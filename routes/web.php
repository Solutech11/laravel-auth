<?php

use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('/api')->controller(Auth::class)->group(function(){
    Route::post('register','RegisterFunc');

    Route::post('login','LoginFunc');

});