<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json(['status' => true], 200));

Route::middleware('throttle:public-api')->group(function () {
  Route::controller(ProjectsController::class)
    ->group(function () {

      Route::get('/projects', 'index')->name('projeect.index');
      Route::post('/projects', 'store')->name('project.store');
    });

  Route::controller(TasksController::class)
    ->group(function () {

      Route::get('/projects/{id}/tasks', 'index')->name('task.index');
      Route::post('/projects/{id}/tasks', 'store')->name('task.store');

      Route::patch('/tasks/{id}', 'update')->name('task.update');
      Route::delete('/tasks/{id}', 'destroy')->name('task.destroy');
    });
});
