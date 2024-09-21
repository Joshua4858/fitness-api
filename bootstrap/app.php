<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',  // Ensure this points to API routes
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi(); // For API routes
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Render JSON responses for API routes
        $exceptions->shouldRenderJsonWhen(function (Request $request) {

            return $request->is('api/*') || $request->expectsJson();
        });

        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {

                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Not authenticated Or Token Expired',
                    ], 401);
                }

                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Resource not found',
                    ], 404);
                }

            }

        });

    })

    ->create();
