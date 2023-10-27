<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
     * Handles the rendering of exception responses for the application.
     *
     * @param    $request Request received
     * @param  Throwable  $exception Exception that was thrown
     * @return JsonResponse Returns a response with a message indicating the error.
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
    }
}
