<?php

declare(strict_types=1);

namespace Finizens\Shared\Infrastructure\Symfony\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        if ('application/json' === $request->headers->get('Content-Type'))
        {
            $response = new JsonResponse();
        }

        if ($exception instanceof HandlerFailedException) {
            foreach ($exception->getNestedExceptions() as $nestedException) {
                $previousException = $nestedException->getPrevious();
                if ($previousException instanceof HttpExceptionInterface) {
                    $response->setStatusCode($previousException->getStatusCode());
                }
            }
        } else if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}

