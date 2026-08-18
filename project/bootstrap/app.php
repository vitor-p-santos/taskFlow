<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e){
            return response()->json(['success' => false, 'message' => $e->getMessage(), $e->getFile(), $e->getLine()], 500);
        });
        $exceptions->render(function (QueryException $e){
            return response()->json(['success' => false, 'message' => 'internal server error'], 500);
        });
        $exceptions->render(function (PDOException $e){
            return response()->json(['success' => false, 'message' => 'internal server error'], 500);
        });
    })->create();
