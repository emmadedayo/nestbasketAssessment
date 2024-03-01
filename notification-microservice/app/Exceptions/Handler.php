<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable; // Add this import
use Illuminate\Http\JsonResponse;
use PhpAmqpLib\Exception\AMQPIOException;

class Handler extends ExceptionHandler
{
    // ...

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception) // Update the type-hint here
    {
        if ($exception instanceof AMQPIOException) {
            return $this->renderAmqpJsonResponse($exception);
        }

        if ($exception instanceof Exception) {
            return $this->renderJsonResponse($exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * Render an exception as a JSON response.
     *
     * @param \Throwable $exception // Update the type-hint here
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJsonResponse(Throwable $exception) // Update the type-hint here
    {
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        return response()->json([
            'message' => $exception->getMessage(),
            'status_code' => $statusCode,
        ], $statusCode);
    }

    protected function renderAmqpJsonResponse(AMQPIOException $exception)
    {
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        return response()->json([
            'message' => $exception->getMessage(),
            'status_code' => $statusCode,
        ], $statusCode);
    }
}
