<?php


namespace App\EventListener;


use App\Factory\NormalizerFactory;
use App\Http\ApiResponse;
use http\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /**
     * @var NormalizerFactory
     */
    private $normalizerFactory;

    /**
     * ExceptionListener constructor.
     *
     * @param NormalizerFactory $normalizerFactory
     */
    public function __construct(NormalizerFactory $normalizerFactory)
    {
        $this->normalizerFactory = $normalizerFactory;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if ('json' === $request->getContentType()) {
            $response = $this->createApiResponse($exception);
            $event->setResponse($response);
        }
    }

    /**
     * Creates the ApiResponse from any Exception
     *
     * @param \Throwable $exception
     *
     * @return ApiResponse
     */
    private function createApiResponse(\Throwable $exception)
    {
        $normalizer = $this->normalizerFactory->getNormalizer($exception);
        $statusCode = ($exception instanceof \Throwable && $exception->getCode() !== 0) ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        try {
            $errors = $normalizer ? $normalizer->normalize($exception) : [];
        } catch (\Throwable $e) {
            $errors = [];
        }

        return new ApiResponse($exception->getMessage(), null, $errors, $statusCode);
    }
}