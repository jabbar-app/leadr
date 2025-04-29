<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register any exception handling callbacks.
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
        // ✅ Tangkap error 403 dan log lebih detail
        if (
            $exception instanceof AuthorizationException ||
            ($exception instanceof HttpException && $exception->getStatusCode() === 403)
        ) {

            Log::warning('403 Forbidden', [
                'user_id' => optional(Auth::user())->id,
                'user_email' => optional(Auth::user())->email,
                'url' => $request->fullUrl(),
                'message' => $exception->getMessage(),
                'ip' => $request->ip(),
            ]);
        }

        return parent::render($request, $exception);
    }
}
