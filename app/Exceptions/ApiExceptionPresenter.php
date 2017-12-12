<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptionPresenter
{
    /**
     * @var array list http messages
     */
    public static $httpMessages = [
        400 => 'The server cannot or will not process the request due to an apparent client error',
        401 => 'Authentication is possible but has failed or not yet been provided',
        403 => 'The user might be logged in but does not have the necessary permissions for the resource',
        404 => 'The requested page could not be found but may be available again in the future',
        405 => 'The request method is not supported for the requested resource',
        406 => 'The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request',
        409 => 'The request could not be processed because of conflict in the request',
        410 => 'The requested page is no longer available',
        411 => 'The request did not specify the length of its content, which is required by the requested resource',
        412 => 'The server does not meet one of the preconditions that the requester put on the request',
        415 => 'The request entity has a media type which the server or resource does not support',
        428 => 'The server requires the request to be conditional',
        429 => 'The user has sent too many requests in a given amount of time',
        500 => 'Internal Server Error',
        503 => 'The server is currently unavailable',
    ];
    /**
     * @var \Exception
     */
    protected $exception;
    /**
     * Constructor
     */
    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }
    /**
     * Render api exception as understandable response
     *
     * @param void
     * @return App\Http\JsonResponse
     */
    public function toResponse()
    {
        if ($this->exception instanceof AuthenticationException) {
            $code = Response::HTTP_UNAUTHORIZED;
        } elseif ($this->exception instanceof AuthorizationException) {
            $code = Response::HTTP_FORBIDDEN;
        } elseif ($this->exception instanceof ValidationException) {
            $code = Response::HTTP_BAD_REQUEST;
        } elseif ($this->exception instanceof NotFoundHttpException
            || $this->exception instanceof ModelNotFoundException
        ) {
            $code = Response::HTTP_NOT_FOUND;
        } elseif ($this->exception instanceof Exception) {
            $code = $this->exception->getCode();
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($this->exception instanceof ValidationException) {
            $errors = $this->exception->validator->errors()->getMessages();
            $message = '';
            foreach ($errors as $error) {
                foreach ($error as $value) {
                    $message .= $value;
                    break;
                }
                if ($message) {
                    break;
                }
            }
        } else if (method_exists($this->exception, 'getMessage')) {
            $message = $this->exception->getMessage();
        } else {
            $message = isset($httpMessages[$code]) ? self::$httpMessages[$code] : '';
        }

        return json([])->withCode($code)->withMessage($message);
    }
}