<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
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
        $this->renderable(static function (DomainException $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], $ex->getHttpResponseCode());
        });

        $this->renderable(static function (ValidationException $ex) {
            return response()->json([
                'message' => 'Validation exception',
                'errors' => $ex->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $this->reportable(static function (BadRequestException $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
                'error' => 'Bad request exception',
            ], Response::HTTP_BAD_REQUEST);
        });

        $this->reportable(static function (NotFoundHttpException $ex) {
            return response()->json([
                    'message' => 'Not found http exception',
                    'error' => $ex->getMessage(),
                ],
                Response::HTTP_NOT_FOUND
            );
        });

        $this->renderable(static function (HandlerFailedException $ex) {
            $domainException = $ex->getPrevious();
            if ($domainException instanceof \Project\Shared\Domain\DomainException) {
                return response()->json(
                    [
                        'message' => $domainException->getMessage(),
                    ],
                    $domainException->getHttpResponseCode()
                );
                // return $domainException->response();
            }
        });

        $this->reportable(static function (AuthenticationException $ex) {
            return response()->json(
                [
                    'message' => 'Authentication exception',
                    'error' => str_replace(['.'], [''], $ex->getMessage()), // 'Unauthorized',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        });

        $this->renderable(static function (ModelNotFoundException $ex) {
            return response()->json([
                    'error' => $ex->getMessage() ?? 'Model not found',
                ],
                Response::HTTP_NOT_FOUND
            );
        });

        $this->reportable(static function (\Exception $ex) {
            return 'awdwad';
//            dd(
//                $ex->getMessage()
//            );
//            return response()->json([
//                // 'message' => 'Unauthenticated',
//                'error' => $ex->getMessage(),
//                'file' => $ex->getFile(),
//                'line' => $ex->getLine(),
//                'previous' => $ex->getPrevious(),
//                'class' => $ex::class,
//            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });

        $this->reportable(static function (\Error $ex) {
            return 'awdwad';
//            dd(
//                $ex->getMessage()
//            );
//            return response()->json([
//                // 'message' => 'Unauthenticated',
//                'error' => $ex->getMessage(),
//                'file' => $ex->getFile(),
//                'line' => $ex->getLine(),
//                'previous' => $ex->getPrevious(),
//                'class' => $ex::class,
//            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });

        $this->reportable(static function (Throwable $ex) {
            return 'awdwad';
            return response()->json([
                // 'message' => 'Unauthenticated',
                'error' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
                'previous' => $ex->getPrevious(),
                'class' => $ex::class,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }

    /**
     * @param $request
     * @param  Throwable  $ex
     * @return JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $ex): JsonResponse
    {
        if ($ex instanceof DomainException) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], $ex->getHttpResponseCode());
        }

        if ($ex instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation exception',
                'errors' => $ex->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($ex instanceof BadRequestException) {
            return response()->json([
                'message' => $ex->getMessage(),
                'error' => 'Bad request exception',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($ex instanceof NotFoundHttpException) {
            return response()->json(
                [
                    'message' => 'Not found http exception',
                    'error' => $ex->getMessage(),
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($ex instanceof AuthenticationException) {
            return response()->json(
                [
                    'message' => 'Authentication exception',
                    'error' => str_replace(['.'], [''], $ex->getMessage()), // 'Unauthorized',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($ex instanceof HandlerFailedException) {
            $domainException = $ex->getPrevious();
            if ($domainException instanceof \Project\Shared\Domain\DomainException) {
                return response()->json(
                    [
                        'message' => $domainException->getMessage(),
                    ],
                    $domainException->getHttpResponseCode()
                );
                // return $domainException->response();
            }
        }

        if ($ex instanceof ModelNotFoundException) {
            return response()->json(
                [
                    'message' => 'Model not found',
                    // 'error' => $ex->getMessage(),
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($ex instanceof AuthorizationException) {
            return response()->json(
                [
                    'message' => trans('error.admin.unauthorized_action', ['companyName' => getenv('APP_NAME')]),
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        return response()->json([
            // 'message' => 'Unauthenticated',
            'error' => $ex->getMessage(),
            'file' => $ex->getFile(),
            'line' => $ex->getLine(),
            'previous' => $ex->getPrevious(),
            'class' => $ex::class,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);

        return parent::render($request, $ex); // TODO: Change the autogenerated stub
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin');
        }

        return redirect()->guest(route('login'));
    }
}
