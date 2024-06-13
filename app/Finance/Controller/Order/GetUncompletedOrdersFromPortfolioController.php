<?php

declare(strict_types=1);

namespace App\Finance\Controller\Order;

use Finizens\Finance\Order\Application\Query\SearchUncompletedOrderFromPortfolio;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class GetUncompletedOrdersFromPortfolioController 
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }
    
    #[Route(
        path: '/orders/{portfolioId}',
        name: 'orders.get',
        methods: ['GET']
    )]
    public function __invoke(int $portfolioId): JsonResponse 
    {
        $response = $this->queryBus->dispatch(
            new SearchUncompletedOrderFromPortfolio($portfolioId) 
        );

        return new JsonResponse($response->last(HandledStamp::class)->getResult());
    }
}
