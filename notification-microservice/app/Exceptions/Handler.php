<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;

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
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Exception) {
            return $this->renderJsonResponse($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render an exception as a JSON response.
     *
     * @param \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJsonResponse(\Exception $exception)
    {
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        return response()->json([
            'message' => $exception->getMessage(),
            'status_code' => $statusCode,
        ], $statusCode);
    }
}
