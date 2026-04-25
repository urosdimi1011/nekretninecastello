<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e )
    {
//        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
//
//        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
//            // Obrada za 404 grešku
//            return response()->view('errors.404', ["exception" => $e], 404);
//        }
//
//        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
//            // Obrada za 405 grešku
//            return response()->view('errors.405', ["exception" => $e], 405);
//        }
//
//        if ($e instanceof \Illuminate\Validation\ValidationException) {
//            // Obrada za greške validacije forme
//            // Preuzmite unos iz sesije
//            return parent::render($request, $e);
//
//        }
//
//        if ($statusCode == 500) {
//            // Obrada za ostale 500 greške
//            return response()->view('errors.errors500', ["exception" => $e], 500);
//        }
//
//        // Ako nije identifikovan određeni tip greške, nastavite sa uobičajenom obradom
        return parent::render($request, $e);
    }
}
