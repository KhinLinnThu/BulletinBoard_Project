<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
    //         return $exception->getResponse();
    //     }

    //     if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
    //         return response()->view('errors.404', [], 404);
    //     }

    //     if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
    //         return response()->view('errors.401', [], 401);
    //     }

    //     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
    //         return response()->view('errors.405', [], 405);
    //     }

    //     if ($exception instanceof \Illuminate\Database\QueryException) {
    //         return response()->view('errors.500', [], 500);
    //     }

    //     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException) {
    //         return response()->view('errors.503', [], 503);
    //     }

    //     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\BadRequestHttpException) {
    //         return response()->view('errors.400', [], $exception->getStatusCode());
    //     }

    //     if (!auth()->user()->role == 1) {
    //         return response()->view('errors.200', [], 200);
    //     }

    //     return parent::render($request, $exception);

    // }

}
