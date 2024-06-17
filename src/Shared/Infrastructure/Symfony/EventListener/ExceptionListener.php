<?php

declare(strict_types=1);

namespace Finizens\Shared\Infrastructure\Symfony\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        if ('application/json' === $request->headers->get('Content-Type'))
        {
            $response = new JsonResponse([
                'message'       => $exception->getMessage(),
                'code'          => $exception->getCode(),
                'traces'        => $exception->getTrace()
            ]);

            $response->setStatusCode($exception->getCode());

            $event->setResponse($response);
        }
    }
}

