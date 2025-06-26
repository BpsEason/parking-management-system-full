<?php
namespace App\Exceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Http\Responses\ApiResponse;
use App\Exceptions\NoAvailableSpaceException;
use App\Exceptions\RecordNotFoundException;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class Handler extends ExceptionHandler
{
    protected $levels = [];
    protected $dontReport = [
        NoAvailableSpaceException::class,
        RecordNotFoundException::class,
        AuthorizationException::class,
        ValidationException::class,
    ];
    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];
    public function register(): void
    {
        $this->renderable(function (NoAvailableSpaceException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error($e->getMessage(), 409);
            }
        });
        $this->renderable(function (RecordNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error($e->getMessage(), 404);
            }
        });
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error($e->getMessage(), 403);
            }
        });
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error('Validation Failed: ' . $e->getMessage(), 422);
            }
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error('Resource not found.', 404);
            }
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
