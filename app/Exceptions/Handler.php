<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Invalid input (422)
        if ($exception instanceof ValidationException) {
            return response()->json(['error' => 'Invalid input.'], 422);
        }

        // Model not found (404)
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(0, 404);
        }

        // Non valid route (404)
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Endpoint not found.'
            ], 404);
        }

        // No funds account (400) - Insufficient Balance
        if ($exception instanceof Exception && str_contains($exception->getMessage(), 'Insufficient balance')) {
            return response()->json(['error' => 'Insufficient balance.'], 400);
        }

        // Invalid transfer (400) - Same Account
        if ($exception instanceof Exception && str_contains($exception->getMessage(), 'Invalid transfer')) {
            return response()->json(['error' => 'Invalid transfer. Origin and destination cannot be the same.'], 400);
        }

        // Invalid Event (400)
        if ($exception instanceof Exception && str_contains($exception->getMessage(), 'Invalid event type')) {
            return response()->json(['error' => 'Invalid event type.'], 400);
        }

        // Default (500)
        return response()->json([
            'error' => 'Something went wrong. Please try again later.'
        ], 500);
    }
}
