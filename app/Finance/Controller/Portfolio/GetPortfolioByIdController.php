<?php

declare(strict_types=1);

namespace App\Finance\Controller\Portfolio;

use Finizens\Finance\Portfolio\Application\Query\SearchPortfolioById;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class GetPortfolioByIdController 
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }
    
    #[Route(
        path: '/portfolios/{id}',
        name: 'portfolios.get',
        methods: ['GET']
    )]
    public function __invoke(int $id): JsonResponse 
    {
        $response = $this->queryBus->dispatch(
            new SearchPortfolioById($id) 
        );

        return new JsonResponse($response->last(HandledStamp::class)->getResult());
    }
}
