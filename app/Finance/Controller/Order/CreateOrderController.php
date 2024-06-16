<?php

declare(strict_types=1);

namespace App\Finance\Controller\Order;

use Finizens\Finance\Order\Application\Command\CreateOrder\CreateOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class CreateOrderController 
{
    public function __construct(private MessageBusInterface $bus)
    {
    }
    
    #[Route(
        path: '/orders',
        name: 'orders.post',
        methods: ['POST']
    )]
    public function __invoke(Request $request): JsonResponse 
    {
        $payload = $request->getPayload();

        $this->bus->dispatch(
            new CreateOrder(
                $payload->get('id'),
                $payload->get('portfolio'),
                $payload->get('allocation'),
                $payload->get('shares'),
                $payload->get('type')
            )
        );

        return new JsonResponse();
    }
}
