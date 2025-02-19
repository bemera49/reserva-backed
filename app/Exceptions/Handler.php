<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (ValidationException $e) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $e->validator->errors()
            ], 422);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json([
                'message' => 'El recurso solicitado no fue encontrado.'
            ], 404);
        });

        $this->renderable(function (Throwable $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'message' => 'Ha ocurrido un error en el servidor.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        });
    }
}
