<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\{Exceptions, Middleware};
use Tymon\JWTAuth\Exceptions\JWTException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            JwtMiddleware::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->render(function (Throwable $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage(),
        //         'file' => $e->getFile(),
        //         'line' => $e->getLine(),
        //     ], 401);
        // });
        $exceptions->render(function (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido ou não encontrado.'
            ], 401);
        });
        $exceptions->render(function (InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        });
        $exceptions->render(function (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'internal server error'
            ], 500);
        });
        $exceptions->render(function (PDOException $e) {
            return response()->json([
                'success' => false,
                'message' => 'internal server error'
            ], 500);
        });
    })->create();
