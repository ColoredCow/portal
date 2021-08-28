<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Mail\ErrorReport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     */
    public function report(Throwable $exception)
    {
        $timeOfException = Carbon::now()->format(config('constants.display_datetime_format'));
        foreach ($this->dontReport as $dontReport) {
            if ($exception instanceof $dontReport) {
                return;
            }
        }

        try {
            //Mail::send(new ErrorReport($exception, $timeOfException));
        } catch (Exception $e) {
            parent::report($e);
        }

        return parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
