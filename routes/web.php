<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return 'hola';
});
Route::get('/', function () {
    return view('welcome');
});
