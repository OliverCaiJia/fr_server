<?php

namespace App\Exceptions;

use App\Helpers\Logger\SLogger;
use Exception;
use Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Helpers\AdminResponseFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Request;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param \Exception $exception
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return $this|\App\Helpers\type|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        //记录异常
        SLogger::getStream()->error($exception);

        if ($exception instanceof NotFoundHttpException) {
            $routeType = $request->segment(1);
            switch ($routeType) {
                case 'api':
                    return response()->json(['error' => 'Not Found'], 404);
                    break;
                case 'web':
                    return redirect('/web/index');
                    break;
                default:
                    return redirect('/admin');
            }
        } elseif ($exception instanceof AuthenticationException || $exception instanceof AuthorizationException) {
            return redirect('/admin/login');
        } else {
            if (app()->environment('production') || app()->environment('test')) {
                if (Request::segment(1) == 'admin') {
                    return AdminResponseFactory::ajaxError($exception->getMessage());
                }
                return redirect()->back()->withErrors($exception->getMessage());
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // 后台系统
        if ($request->segment(1) == 'admin') {
            return redirect()->guest('admin/login');
        }

        return redirect()->guest('web/login');
    }
}
