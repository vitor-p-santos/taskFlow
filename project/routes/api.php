<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json(['status' => true], 200));

Route::middleware('throttle:public-api')->group(function () {
  Route::controller(ProjectsController::class)
    ->group(function () {

      Route::get('/projects', 'get')->name('getProject');
      Route::post('/projects', 'store')->name('storeProject');
    });

  Route::controller(TasksController::class)
    ->group(function () {

      Route::get('/projects/{id}/tasks', 'get')->name('getTasks');
      Route::post('/projects/{id}/tasks', 'store')->name('storeTask');

      Route::patch('/tasks/{id}', 'patch');
      Route::delete('/tasks/{id}', 'delete');
    });
});
