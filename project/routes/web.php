<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', function () {
    return view('welcome');
});
Route::get('/projects/{id}/tasks', function () {
    return view('welcome');
});

Route::redirect( '{any}', '/');
