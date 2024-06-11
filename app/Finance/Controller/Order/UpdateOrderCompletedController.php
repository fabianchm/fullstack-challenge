<?php

declare(strict_types=1);

namespace App\Finance\Controller\Order;

use Finizens\Finance\Order\Application\Command\UpdateOrderCompleted\UpdateOrderCompleted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class UpdateOrderCompletedController 
{
    public function __construct(private MessageBusInterface $bus)
    {
    }
    
    #[Route(
        path: '/orders/{id}',
        name: 'orders_update_completed.patch',
        methods: ['PATCH']
    )]
    public function __invoke(int $id, Request $request): JsonResponse 
    {
        $response = $this->bus->dispatch(
            new UpdateOrderCompleted(
                $id,
                $request->getPayload()->get('status')
            )
        );

        return new JsonResponse();
    }
}
