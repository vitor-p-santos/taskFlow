<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json(['status' => true], 200));

Route::middleware(['throttle:public-api'])->group(function () {

  // ==========================================
  // 🔐 DOMÍNIO: AUTH
  // ==========================================
  Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');

    Route::post('/refresh', 'refresh');

    Route::middleware('auth:api')->group(function () {
      Route::delete('/logout', 'logout');
    });
  });

  // ==========================================
  // 👤 DOMÍNIO: USERS
  // ==========================================
  Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::post('/', 'register');

    Route::middleware('auth:api')->group(function () {
      Route::get('/me', 'me');
      Route::get('/me/statistic', 'statistic');
    });
  });


  // ==========================================
  // 💼 DOMÍNIO: PROJECTS & TASKS (Tudo Privado)
  // ==========================================
  Route::middleware('auth:api')->group(function () {

    Route::prefix('projects')->controller(ProjectsController::class)->group(function () {
      Route::get('/', 'index')->name('project.index');
      Route::post('/', 'store')->name('project.store');
    });

    Route::controller(TasksController::class)->group(function () {
      Route::get('/projects/{id}/tasks', 'index')->name('task.index');
      Route::post('/projects/{id}/tasks', 'store')->name('task.store');

      Route::patch('/tasks/{id}', 'update')->name('task.update');
      Route::delete('/tasks/{id}', 'destroy')->name('task.destroy');
    });
  });
});
